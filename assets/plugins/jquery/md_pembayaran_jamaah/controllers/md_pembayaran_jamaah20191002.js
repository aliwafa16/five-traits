var db = require('../../../database')
var MongoClient = require('mongodb').MongoClient
var ObjectId = require('mongodb').ObjectID;
var bodyParser = require('body-parser');
var dateFormat = require('dateformat');
var MDTable = require('mongo-datatable');
var sender_wa = require('../../../sender/sender_wa');
var semail = require('../../../sender/semail');
var mseriesno = require("../../../modules/md_series_no/controllers/md_series_no.js");
var asyncjs = require('async');

exports.fnseriesno = function(req, res) {
    mseriesno.fnget_seriesno('BYR', function(err, vseriesno) {
        res.json({
            f_kode_bayar: vseriesno
        });
    })
    mseriesno.fnupdate_seriesno('BYR')
}
exports.index = function(req, res) {
    if (req.session.akses.view) {
        var vars = {
            title: 'Pembayaran Jamaah',
            subtitle: '',
        };
        vars.button = req.session.akses;
        res.render(__dirname + '/../views/vw_data.html', vars);
    } else {
        res.render('accessdenied');
    }
};
exports.bayar_booking = function(req, res) {
    var info = req.query;
    var vquery = [{
        $match: {
            _id: ObjectId(info.id)
        }
    }, {
        $group: {
            '_id': {
                '_id': '$_id',
                'f_produk': '$f_id_produk',
                'f_kode_booking': '$f_kode_booking',
                'f_booking_date': '$f_booking_date',
                'f_nama_pendaftar': '$f_nama_pendaftar',
                'f_hp': '$f_hp',
                'f_email': '$f_email',
                'f_jml_seat_booking': '$f_jml_seat_booking'
            }
        }
    }, {
        $lookup: {
            from: 't_produk',
            localField: '_id.f_produk',
            foreignField: '_id',
            as: 'f_produk_detail'
        }
    }]
    db.collection('t_booking').aggregate(vquery).toArray(function(err, result) {
        var vars = {
            title: 'Form Pembayaran Booking Jamaah',
            subtitle: '',
            module: 'md_pembayaran_jamaah',
            act: 'bayar',
            result: result,
        };
        res.render(__dirname + '/../views/vw_form_booking.html', vars);
    });
};
exports.bayar = function(req, res) {
    var info = req.query;
    var vquery = [{
        $match: {
            _id: ObjectId(info.id)
        }
    }, {
        $group: {
            '_id': {
                '_id': '$_id',
                'f_produk': '$f_id_produk',
                'f_kode_booking': '$f_kode_booking',
                'f_booking_date': '$f_booking_date',
                'f_nama_pendaftar': '$f_nama_pendaftar',
                'f_hp': '$f_hp',
                'f_email': '$f_email',
                'f_jml_seat_booking': '$f_jml_seat_booking'
            }
        }
    }, {
        $lookup: {
            from: 't_produk',
            localField: '_id.f_produk',
            foreignField: '_id',
            as: 'f_produk_detail'
        }
    }]
    db.collection('t_booking').aggregate(vquery).toArray(function(err, result) {
        var vars = {
            title: 'Form Pembayaran Jamaah',
            subtitle: '',
            module: 'md_pembayaran_jamaah',
            act: 'bayar',
            result: result,
        };
        res.render(__dirname + '/../views/vw_form.html', vars);
    });
};
exports.data_booking = function(req, res) {
    var vquery = []
    vquery.push({
        $match: {
            f_kode_booking: req.param('kodebooking')
        }
    });
    vquery.push({
        $sort: {
            '_id': -1
        }
    }, {
        $group: {
            _id: {
                "_id": '$_id',
                "f_id_produk": '$f_id_produk',
                "f_kode_flight": "",
                "f_kode_booking": '$f_kode_booking',
                "f_created_on": new Date(),
                "f_created_by": req.session.user
            }
        }
    }, {
        $lookup: {
            from: 't_invoice',
            localField: '_id.f_kode_booking',
            foreignField: 'f_kode_booking',
            as: 'biaya_detail'
        }
    }, {
        $project: {
            "_id": "$_id._id",
            "f_id_produk": '$_id.f_id_produk',
            "f_kode_flight": "",
            "f_kode_booking": '$_id.f_kode_booking',
            "f_biaya_detail": '$biaya_detail',
            "f_created_on": '$_id.f_created_on',
            "f_created_by": '$_id.f_created_by'
        }
    })
    db.get().collection('t_booking').count({}, function(err, resultcount) {
        db.get().collection('t_booking').aggregate(vquery).toArray(function(err, result) {
            //      if (err) return callback(err);
            var djson = {
                draw: req.param('draw'),
                recordsTotal: resultcount,
                recordsFiltered: resultcount,
                data: result
            }
            res.json(djson);
        })
    })
};
exports.data_tagihan_booking = function(req, res) {
  var info = req.body;
  var sortObject = {};
  var no_order_column = info.order[0].column;
  var order_column_name = info.columns[no_order_column].data;
  var order_column_by = (info.order[0].dir == 'asc') ? 1 : -1;;
  sortObject[order_column_name] = order_column_by;
  var response = {
    draw: 0,
    recordsTotal: 0,
    recordsFiltered: 0,
    data: [],
    error: null
  };
  var cgroup =[
    //{ $match : { f_jenis_produk : 'Umroh'}},
    {
        $lookup: {
            from: 't_produk',
            localField: 'f_id_produk',
            foreignField: '_id',
            as: 'produk_detail'
        }
    },
    {$unwind : "$produk_detail"}
    ];
  var group =[
    //{ $match : { f_jenis_produk : 'Umroh'}},
    {
        $lookup: {
            from: 't_produk',
            localField: 'f_id_produk',
            foreignField: '_id',
            as: 'produk_detail'
        }
    },
    {$unwind : "$produk_detail"}
    ];

    if (req.param('kodebooking') != '') {
        cgroup.push({ $match: { 'f_kode_booking': { $regex : req.param('kodebooking'), $options: 'i'} }})
        group.push({ $match: { 'f_kode_booking': { $regex : req.param('kodebooking'), $options: 'i'} }})
    }

    if (req.param('nama') != '') {
        cgroup.push({ $match: { 'f_nama_pendaftar': { $regex : req.param('nama'), $options: 'i'} }})
        group.push({ $match: { 'f_nama_pendaftar': { $regex : req.param('nama'), $options: 'i'} }})
    }

	if(typeof info.search.value != 'undefied') {
		if(info.search.value != '') {
			var src = [];
			for(var i= 0;i<info.columns.length;i++) {
				var _src = {};
				_src[info.columns[i].data] = { $regex : info.search.value, $options: 'i'};
				if(info.columns[i].searchable == 'true') src.push(_src);
			}
			var cari_data = { $match : { $or : src } };
			cgroup.push(cari_data);
			group.push(cari_data);
		}
	}


  asyncjs.waterfall([
    function(callback) {
      cgroup.push({$count: "total"});
      response.draw = parseInt(info.draw, 10);
      db.collection('t_booking').aggregate(cgroup).toArray(function(error, result) {
            if (error) {
              return callback(error, null);
            }

            if(result.length >0) {
          response.recordsTotal = result[0].total;
          response.recordsFiltered = result[0].total;
              return callback(null);
        }
        else
        {
          return callback(null);
        }
      });
    },
    function(callback) {
      var project = {
          $project: {
               _id                   : '$_id',
               f_kode_booking        : '$f_kode_booking',
               f_type_booking        : '$f_type_booking',
               f_booking_date        : '$f_booking_date',
               f_kode                : '$produk_detail.f_kode',
               f_produk              : '$produk_detail.f_produk',
               f_nama_pendaftar      : '$f_nama_pendaftar',
               f_hp                  : '$f_hp',
               f_email               : '$f_email',
               f_status              : '$f_status',
               f_biaya_booking       : '$f_biaya_booking',
               f_jml_seat_booking    : '$f_jml_seat_booking',
               f_total_biaya_booking : '$f_total_biaya_booking',
               f_due_date_booking    : '$f_due_date_booking',
               f_jml_tagihan         : '$f_jml_tagihan',
               f_jml_sisa_tagihan    : '$f_jml_sisa_tagihan',
               f_keterangan          : '$f_keterangan',
          }
        };
      group.push(project);
      group.push({$sort: sortObject });
      console.log(JSON.stringify(group))
      if(parseInt(info.length) > 0) {
        group.push({$skip: parseInt(info.start)});
        group.push({$limit: parseInt(info.length)});
      }
      db.collection('t_booking').aggregate(group)
      .toArray(function(error, result) {
            if (error) {
              return callback(error, null);
            }

        response.data = result;
        return callback(null);
      });
    }
  ],function() {
    res.send(JSON.stringify(response));
  });
};

exports.data_tagihan_booking1 = function(req, res) {
    getPromiseBooking(req, res)
};

function getPromiseBooking(req, res) {
    new Promise(function(resolve, reject) {
        //=====Get Firts Colom======
        setTimeout(() => resolve(getHeaderBooking(req, res)), 100);
        //=====Close Get Firts Colom======
    }).then(function(resultfirts) {
        //      console.log(resultfirts)
        return new Promise((resolve, reject) => { // (*)
            var promises = [];
            resultfirts.forEach(function(row) {
                var vdata = {
                    '_id': row['_id'],
                    'f_kode_booking': row['f_kode_booking'],
                    'f_status': row['f_status'],
                    'f_nama_pendaftar': row['f_nama_pendaftar'],
                    'f_kode': row['f_kode'],
                    'f_produk': row['f_produk'],
                    'f_hp': row['f_hp'],
                    'f_jml_seat_booking': row['f_jml_seat_booking'],
                    //                     'f_jml_tagihan': row['f_jml_tagihan'],
                }
                promises.push(new Promise(resolve => setTimeout(resolve, 0, getdataBooking(vdata, req, res))))
            })
            Promise.all(promises).then(function(resultjamaah) {
                db.get().collection('t_booking').count({}, function(err, resultcount) {
                    var djson = {
                        //                    draw: req.param('draw'),
                        recordsTotal: resultcount,
                        recordsFiltered: resultcount,
                        data: resultjamaah
                    }
                    res.json(djson);
                })
            })
        })
    })
}

function getHeaderBooking(req, res) {
    return new Promise((resolve, reject) => {
        var vskip = (Number(req.param('start')));
        var vquery = []
        var info = req.query;
        //      console.log(info)
        // if(info.kodebooking !=''){
        // vquery.push(
        //   {$match:{'f_kode_booking' : info.kodebooking}}
        // )
        // }
        if(parseInt(req.param('length')) > 0) {
	        vquery.push({
	            $skip: vskip
	        }, {
	            $limit: Number(req.param('length'))
	        });
		}
        vquery.push({
            $sort: {
                '_id': -1
            }
        })
        // if (req.param('kodebooking') != '') {
        //     var str = req.param('kodebooking')
        //     var strup = str.toUpperCase();
        //     //            vquery.push({$match:{'f_kode_booking': str.toUpperCase() }});
        //     vquery.push({
        //         $match: {
        //             'f_kode_booking': new RegExp('\.*' + strup + '\.', 'i')
        //         }
        //     });
        // }
        // if (req.param('kodebooking') != '') {
        //     var str = req.param('kodebooking')
        //     vquery.push({
        //         $match: {
        //             // 'f_kode_booking': str.toUpperCase()
        //             'f_kode_booking': new RegExp('\.*' + str + '\.', 'i')
        //         }
        //     });
        // }
        if (req.param('kodebooking') != '') {
            vquery.push({
                $match: {
                    $or: [{
                        f_kode_booking: {
                            $regex: req.param('kodebooking')
                        }
                    }]
                }
            });
        }
        if (req.param('nama') != '') {
            vquery.push({
                $match: {
                    $or: [{
                        f_nama_pendaftar: {
                            $regex: req.param('nama')
                        }
                    }]
                }
            });
        }
        // if (req.param('nama') != '') {
        //     var strnama = req.param('nama')
        //     vquery.push({
        //         $match: {
        //             'f_nama_pendaftar': new RegExp('\.*' + strnama + '\.', 'i')
        //         }
        //     });
        // }
        vquery.push({
            $group: {
                _id: {
                    _id: '$_id',
                    f_kode_booking: '$f_kode_booking',
                    f_type_booking: '$f_type_booking',
                    f_booking_date: '$f_booking_date',
                    f_id_produk: '$f_id_produk',
                    f_nama_pendaftar: '$f_nama_pendaftar',
                    f_hp: '$f_hp',
                    f_email: '$f_email',
                    f_status: '$f_status',
                    f_biaya_booking: '$f_biaya_booking',
                    f_jml_seat_booking: '$f_jml_seat_booking',
                    f_total_biaya_booking: '$f_total_biaya_booking',
                    f_due_date_booking: '$f_due_date_booking',
                    f_jml_tagihan: '$f_jml_tagihan',
                    f_jml_sisa_tagihan: '$f_jml_sisa_tagihan',
                    f_keterangan: '$f_keterangan',
                }
            }
        }, {
            $lookup: {
                from: 't_produk',
                localField: '_id.f_id_produk',
                foreignField: '_id',
                as: 'produk_detail'
            }
        })
        vquery.push({
            $project: {
                _id: '$_id._id',
                f_kode_booking: '$_id.f_kode_booking',
                f_type_booking: '$_id.f_type_booking',
                f_booking_date: '$_id.f_booking_date',
                f_kode: '$produk_detail.f_kode',
                f_produk: '$produk_detail.f_produk',
                f_nama_pendaftar: '$_id.f_nama_pendaftar',
                f_hp: '$_id.f_hp',
                f_email: '$_id.f_email',
                f_status: '$_id.f_status',
                f_biaya_booking: '$_id.f_biaya_booking',
                f_jml_seat_booking: '$_id.f_jml_seat_booking',
                f_total_biaya_booking: '$_id.f_total_biaya_booking',
                f_due_date_booking: '$_id.f_due_date_booking',
                //           f_jml_tagihan         : '$_id.f_jml_tagihan',
                //           f_jml_sisa_tagihan    : '$_id.f_jml_sisa_tagihan',
                f_keterangan: '$_id.f_keterangan',
            }
        })
        //       console.log(vquery)
        db.get().collection('t_booking').aggregate(vquery).toArray(function(err, result) {
            //if (err) return callback(err);
            resolve(result)
        })
    })
}

function getdataBooking(vdata, req, res) {
    return new Promise((resolve, reject) => {
        var vquery = []
        if (vdata['f_status'] == 'Booking') {
            vquery.push({
                $match: {
                    f_kode_booking: vdata['f_kode_booking']
                }
            })
        } else {
            vquery.push({
                $match: {
                    f_kode_booking: vdata['f_kode_booking'],
                    'f_kode_jamaah': {
                        $ne: ''
                    }
                }
            })
        }
        vquery.push({
            $group: {
                _id: {
                    f_kode_booking: '$f_kode_booking'
                },
                sum_tagihan: {
                    $sum: '$f_biaya'
                },
                sum_sisa_tagihan: {
                    $sum: '$f_jml_sisa_tagihan'
                }
            }
        })
        db.get().collection('t_invoice').aggregate(vquery).toArray(function(err, result) {
            console.log(result)
            if (result.length > 0) {
                var json = {
                    '_id': vdata['_id'],
                    'f_kode_booking': vdata['f_kode_booking'],
                    'f_status': vdata['f_status'],
                    'f_nama_pendaftar': vdata['f_nama_pendaftar'],
                    'f_kode': vdata['f_kode'],
                    'f_produk': vdata['f_produk'],
                    'f_hp': vdata['f_hp'],
                    'f_jml_seat_booking': vdata['f_jml_seat_booking'],
                    'f_jml_tagihan': result[0]['sum_tagihan'],
                    'f_jml_sisa_tagihan': result[0]['sum_sisa_tagihan'],
                    'f_biaya_detail': vdata['f_biaya_detail']
                }
                resolve(json)
            }
            //          console.log(json)
        })
    });
}
exports.data_jamaah = function(req, res) {
    getPromise(req, res)
};

function getPromise(req, res) {
    new Promise(function(resolve, reject) {
        //=====Get Firts Colom======
        setTimeout(() => resolve(getHeader(req, res)), 100);
        //=====Close Get Firts Colom======
    }).then(function(resultfirts) {
        return new Promise((resolve, reject) => { // (*)
            var promises = [];
            resultfirts.forEach(function(row) {
                var vdata = {
                    'f_kode_jamaah': row['f_kode_jamaah'],
                    'f_nama_jamaah': row['f_nama_jamaah'],
                    // 'f_jml_tagihan': row['f_jml_tagihan'],
                    'f_biaya_detail': row['f_biaya_detail']
                }
                promises.push(new Promise(resolve => setTimeout(resolve, 0, getdata(vdata, req, res))))
            })
            Promise.all(promises).then(function(resultjamaah) {
                var djson = {
                    draw: 0,
                    recordsTotal: 1,
                    recordsFiltered: 1,
                    data: resultjamaah
                }
                res.json(djson);
            })
        })
    })
}

function getHeader(req, res) {
    return new Promise((resolve, reject) => {
        var vquery = []
        vquery.push({
            $match: {
                f_kode_booking: req.param('kodebooking')
            }
        });
        vquery.push({
            $sort: {
                '_id': -1
            }
        }, {
            $group: {
                _id: {
                    "_id": '$_id',
                    "f_id_produk": '$f_id_produk',
                    "f_kode_flight": "",
                    "f_kode_booking": '$f_kode_booking',
                    "f_room": '$f_room',
                    "f_kode_jamaah": '$f_kode_jamaah',
                    "f_nama_jamaah": '$f_nama_jamaah',
                    "f_gender": '$f_gender',
                    "f_tempat_lahir": '$f_tempat_lahir',
                    "f_tgl_lahir": '$f_tgl_lahir',
                    "f_hp": '$f_hp',
                    "f_email": '$f_email',
                    "f_alamat": '$f_alamat',
                    "f_catatan": '$f_catatan',
                    "f_berkas": '$f_berkas',
                    "f_group": '$f_kode_group_family',
                    "f_no_passport": '$f_no_passport',
                    "f_kota_rilis_passport": '$f_kota_rilis_passport',
                    "f_tgl_rilis_passport": '$f_tgl_rilis_passport',
                    "f_tgl_expired_passport": '$f_tgl_expired_passport',
                    "f_addon": '$f_addon',
                    "f_kelas_bisnis": '$f_kelas_bisnis',
                    "f_guide_dorong": '$f_guide_dorong',
                    "f_guide_khusus": '$f_guide_khusus',
                    "f_sharing_bed": '$f_sharing_bed',
                    "f_infant": '$f_infant',
                    "f_tiket_id": '$f_tiket_id',
                    //  "f_jml_tagihan": '$f_jml_tagihan',
                    //"f_jml_sisa_tagihan": '$f_jml_sisa_tagihan',
                    "f_created_on": new Date(),
                    "f_created_by": req.session.user
                }
            }
        }, {
            $lookup: {
                from: 't_invoice',
                localField: '_id.f_kode_jamaah',
                foreignField: 'f_kode_jamaah',
                as: 'biaya_detail'
            }
        }, {
            $project: {
                "_id": "$_id._id",
                "f_id_produk": '$_id.f_id_produk',
                "f_kode_flight": "",
                "f_kode_booking": '$_id.f_kode_booking',
                "f_kode_jamaah": '$_id.f_kode_jamaah',
                "f_room": '$_id.f_room',
                "f_nama_jamaah": '$_id.f_nama_jamaah',
                "f_gender": '$_id.f_gender',
                "f_tempat_lahir": '$_id.f_tempat_lahir',
                "f_tgl_lahir": '$_id.f_tgl_lahir',
                "f_hp": '$_id.f_hp',
                "f_email": '$_id.f_email',
                "f_alamat": '$_id.f_alamat',
                "f_catatan": '$_id.f_catatan',
                "f_berkas": '$_id.f_berkas',
                "f_group": '$_id.f_kode_group_family',
                "f_no_passport": '$_id.f_no_passport',
                "f_kota_rilis_passport": '$_id.f_kota_rilis_passport',
                "f_tgl_rilis_passport": '$_id.f_tgl_rilis_passport',
                "f_tgl_expired_passport": '$_id.f_tgl_expired_passport',
                "f_addon": '$_id.f_addon',
                "f_kelas_bisnis": '$_id.f_kelas_bisnis',
                "f_guide_dorong": '$_id.f_guide_dorong',
                "f_guide_khusus": '$_id.f_guide_khusus',
                "f_sharing_bed": '$_id.f_sharing_bed',
                "f_infant": '$_id.f_infant',
                "f_tiket_id": '$_id.f_tiket_id',
                //"f_jml_tagihan": '$_id.f_jml_tagihan',
                //"f_jml_sisa_tagihan": '$_id.f_jml_sisa_tagihan',
                "f_biaya_detail": '$biaya_detail',
                "f_created_on": '$_id.f_created_on',
                "f_created_by": '$_id.f_created_by'
            }
        })
        db.get().collection('t_master_data_jamaah').aggregate(vquery).toArray(function(err, result) {
            if (err) return callback(err);
            resolve(result)
        })
    })
}

function getdata(vdata, req, res) {
    return new Promise((resolve, reject) => {
        var vquery = [{
            $match: {
                f_kode_jamaah: vdata['f_kode_jamaah']
            }
        }, {
            $group: {
                _id: {
                    f_kode_jamaah: '$f_kode_jamaah'
                },
                sum_tagihan: {
                    $sum: '$f_biaya'
                },
                sum_sisa_tagihan: {
                    $sum: '$f_jml_sisa_tagihan'
                }
            }
        }]
        db.get().collection('t_invoice').aggregate(vquery).toArray(function(err, result) {
            console.log(result)
            var sum_tagihan;
            var sum_sisa_tagihan;
            if (Number(result.length) > 0) {
                sum_tagihan = result[0]['sum_tagihan'];
                sum_sisa_tagihan = result[0]['sum_sisa_tagihan'];
            } else {
                sum_tagihan = 0;
                sum_sisa_tagihan = 0;
            }
            var json = {
                f_kode_jamaah: vdata['f_kode_jamaah'],
                f_nama_jamaah: vdata['f_nama_jamaah'],
                f_jml_tagihan: sum_tagihan,
                f_jml_sisa_tagihan: sum_sisa_tagihan,
                f_biaya_detail: vdata['f_biaya_detail']
            }
            resolve(json)
            //          console.log(json)
        })
    });
}
exports.data_jamaah__ = function(req, res) {
    var vquery = []
    vquery.push({
        $match: {
            f_kode_booking: req.param('kodebooking')
        }
    });
    vquery.push({
        $sort: {
            '_id': -1
        }
    }, {
        $group: {
            _id: {
                "_id": '$_id',
                "f_id_produk": '$f_id_produk',
                "f_kode_flight": "",
                "f_kode_booking": '$f_kode_booking',
                "f_room": '$f_room',
                "f_kode_jamaah": '$f_kode_jamaah',
                "f_nama_jamaah": '$f_nama_jamaah',
                "f_gender": '$f_gender',
                "f_tempat_lahir": '$f_tempat_lahir',
                "f_tgl_lahir": '$f_tgl_lahir',
                "f_hp": '$f_hp',
                "f_email": '$f_email',
                "f_alamat": '$f_alamat',
                "f_catatan": '$f_catatan',
                "f_berkas": '$f_berkas',
                "f_group": '$f_kode_group_family',
                "f_no_passport": '$f_no_passport',
                "f_kota_rilis_passport": '$f_kota_rilis_passport',
                "f_tgl_rilis_passport": '$f_tgl_rilis_passport',
                "f_tgl_expired_passport": '$f_tgl_expired_passport',
                "f_addon": '$f_addon',
                "f_kelas_bisnis": '$f_kelas_bisnis',
                "f_guide_dorong": '$f_guide_dorong',
                "f_guide_khusus": '$f_guide_khusus',
                "f_sharing_bed": '$f_sharing_bed',
                "f_infant": '$f_infant',
                "f_tiket_id": '$f_tiket_id',
                "f_jml_tagihan": '$f_jml_tagihan',
                "f_jml_sisa_tagihan": '$f_jml_sisa_tagihan',
                "f_created_on": new Date(),
                "f_created_by": req.session.user
            }
        }
    }, {
        $lookup: {
            from: 't_invoice',
            localField: '_id.f_kode_jamaah',
            foreignField: 'f_kode_jamaah',
            as: 'biaya_detail'
        }
    }, {
        $project: {
            "_id": "$_id._id",
            "f_id_produk": '$_id.f_id_produk',
            "f_kode_flight": "",
            "f_kode_booking": '$_id.f_kode_booking',
            "f_kode_jamaah": '$_id.f_kode_jamaah',
            "f_room": '$_id.f_room',
            "f_nama_jamaah": '$_id.f_nama_jamaah',
            "f_gender": '$_id.f_gender',
            "f_tempat_lahir": '$_id.f_tempat_lahir',
            "f_tgl_lahir": '$_id.f_tgl_lahir',
            "f_hp": '$_id.f_hp',
            "f_email": '$_id.f_email',
            "f_alamat": '$_id.f_alamat',
            "f_catatan": '$_id.f_catatan',
            "f_berkas": '$_id.f_berkas',
            "f_group": '$_id.f_kode_group_family',
            "f_no_passport": '$_id.f_no_passport',
            "f_kota_rilis_passport": '$_id.f_kota_rilis_passport',
            "f_tgl_rilis_passport": '$_id.f_tgl_rilis_passport',
            "f_tgl_expired_passport": '$_id.f_tgl_expired_passport',
            "f_addon": '$_id.f_addon',
            "f_kelas_bisnis": '$_id.f_kelas_bisnis',
            "f_guide_dorong": '$_id.f_guide_dorong',
            "f_guide_khusus": '$_id.f_guide_khusus',
            "f_sharing_bed": '$_id.f_sharing_bed',
            "f_infant": '$_id.f_infant',
            "f_tiket_id": '$_id.f_tiket_id',
            "f_jml_tagihan": '$_id.f_jml_tagihan',
            "f_jml_sisa_tagihan": '$_id.f_jml_sisa_tagihan',
            "f_biaya_detail": '$biaya_detail',
            "f_created_on": '$_id.f_created_on',
            "f_created_by": '$_id.f_created_by'
        }
    })
    db.get().collection('t_master_data_jamaah').count({}, function(err, resultcount) {
        db.get().collection('t_master_data_jamaah').aggregate(vquery).toArray(function(err, result) {
            //      if (err) return callback(err);
            var djson = {
                draw: req.param('draw'),
                recordsTotal: resultcount,
                recordsFiltered: resultcount,
                data: result
            }
            res.json(djson);
        })
    })
};
exports.add = function(req, res) {
    if (req.session.akses.add == 1) {
        var vars = {
            title: 'From Md_pembayaran_jamaah',
            subtitle: 'input data md_pembayaran_jamaah',
            module: 'md_pembayaran_jamaah',
            act: 'add',
        };
        res.render(__dirname + '/../views/vw_form.html', vars);
    } else {
        res.render('accessdenied');
    }
};
exports.edit = function(req, res) {
    if (req.session.akses.edit == 1) {
        var vars = {
            title: 'From Md_pembayaran_jamaah',
            subtitle: 'edit data md_pembayaran_jamaah',
            module: 'md_pembayaran_jamaah',
            id: req.param('id'),
            act: 'edit',
        };
        res.render(__dirname + '/../views/vw_form.html', vars);
    } else {
        res.render('accessdenied');
    }
};
//--------------------------------------------------- connection with db
exports.rowId = function(req, res) {
    var info = req.query;
    db.collection('t_pembayaran').findOne({
        '_id': ObjectId(info.id)
    }, function(err, item) {
        if (item) res.send(JSON.stringify(item));
        else res.send(JSON.stringify({
            success: false
        }));
    });
};
exports.data = function(req, res) {
    var options = req.query;
    var csearch = [];
    options.caseInsensitiveSearch = false;
    options.showAlertOnError = true;
    options.customQuery = {};
    if (csearch.length > 0) {
        options.customQuery = csearch.length > 0 ? {
            $and: csearch
        } : {}
    }
    new MDTable(db.get()).get('t_pembayaran', options, function(err, result) {
        if (err) return callback(err);
        res.json(result);
    });
};
exports.combodata = function(req, res) {
    var options = req.query;
    var datacombo = [];
    if (options.q) var regexValue = {
        f_id_produk: new RegExp('\.*' + options.q + '\.', 'i')
    };
    else var regexValue = {};
    db.collection('t_pembayaran').find(regexValue).limit(10).toArray(function(err, result) {
        if (result) {
            var i = 0;
            result.forEach(function(items) {
                datacombo[i] = {
                    'id': items._id,
                    'text': items.f_id_produk
                };
                i++;
            });
        }
        res.send(JSON.stringify({
            result: datacombo
        }));
    });
}
exports.insertbooking = function(req, res) {
    if (req.session.akses.add == 1) {
        var info = req.body;
        for (i = 0; i < 1; i++) {
            if (info.f_jml_bayar[i] != '') {
                const kodebooking = info.f_kode_booking;
                const kodeinvoice = info.f_kode_invoice[i];
                //        var kodejamaah = info.f_kode_jamaah[i];
                const kodebayar = info.f_kode_bayar;
                const namabiaya = info.f_nama_biaya[i];
                const sisabiaya = info.f_jml_sisa_tagihan[i].replace(/[\,]/g, '');
                const biaya = info.f_biaya[i].replace(/[\,]/g, '');
                const bayar = info.f_jml_bayar[i].replace(/[\,]/g, '');
                db.collection("t_booking").find({
                    f_kode_booking: info.f_kode_booking
                }).toArray(function(err, resultB) {
                    //          db.collection("t_master_data_jamaah").find({f_kode_jamaah:kodejamaah}).toArray(function(err, resultJ) {
                    var inittagihanbooking = resultB[0]['f_jml_sisa_tagihan'];
                    var lasttagihanbooking = Number(inittagihanbooking) - Number(bayar.replace(/[\,]/g, ''));
                    var vData = [{
                        f_id_produk: ObjectId(info.f_id_paket),
                        f_kode_booking: kodebooking,
                        f_kode_bayar: kodebayar,
                        f_kode_biaya: 'Booking',
                        f_nama_biaya: namabiaya,
                        f_jml_biaya: parseFloat(biaya),
                        f_jml_sisa_tagihan_biaya: parseFloat(sisabiaya),
                        f_init_sisa_tagihan_booking: parseFloat(inittagihanbooking),
                        f_jml_bayar: parseFloat(bayar),
                        f_last_sisa_tagihan_booking: parseFloat(lasttagihanbooking),
                        f_created_on: new Date(),
                        f_created_by: req.session.user
                    }];
                    db.collection('t_pembayaran').insert(vData, {
                        safe: true
                    }, function(err, result) {});
                    var vcal = Number(sisabiaya) - Number(bayar);
                    db.collection('t_invoice').updateOne({
                        '_id': {
                            $eq: ObjectId(kodeinvoice)
                        }
                    }, {
                        $set: {
                            'f_jml_sisa_tagihan': Number(vcal)
                        }
                    }, function(err, result) {
                        var vstatus_booked; var update_booking = {};
                        if (vcal < 1) {
                            insert_jamaah(info.f_id_paket, kodebooking, Number(resultB[0]['f_jml_seat_booking']), Number(resultB[0]['f_biaya_booking']), Number(resultB[0]['f_jml_tagihan']), req, res)
                            vstatus_booked = 'Booked'
							update_booking = { 'f_status': vstatus_booked, f_jml_sisa_tagihan: lasttagihanbooking }
                            update_komisi_prospek(kodebooking,resultB[0]['f_hp'],resultB[0]['f_jml_seat_booking'], req, res)

                        } else {
                            vstatus_booked = 'Booking'
							update_booking = { 'f_status': vstatus_booked }
                        }
                        db.collection('t_booking').updateOne({
                            'f_kode_booking': info.f_kode_booking
                        }, {
                            $set: update_booking
                        }, function(err, result) {});


                    });
                    //=====Update Tagihan Terakhir per Booking
                    //          fnupdateTagihanBooking(kodebooking,kodejamaah,lasttagihanbooking,lasttagihanjamaah);
                    //=====Update Tagihan Terakhir per jamaah
                    //          fnupdateTagihanJamaah(kodejamaah,lasttagihanjamaah);
                    //          console.log(lasttagihanbooking + "booking===")
                    //          console.log(lasttagihanjamaah + "jamaah===")
                    //        })
                    db.collection('t_template_wa').findOne({
                        kode_wa: 'NOTIF4'
                    }, function(err, msgwa) {
                        sender_wa.fnSender(resultB[0]['f_hp'], msgwa['content_wa']);
                    });


                })
            }
        }
        for (x = 0; x < info.f_bayar.length; x++) {
            var vDataMetode = [{
                f_id_produk: ObjectId(info.f_id_paket),
                f_tgl_bayar: info.f_tgl_bayar,
                f_kode_booking: info.f_kode_booking,
                f_kode_bayar: info.f_kode_bayar,
                f_metode_bayar: info.f_metode_bayar[x],
                f_total_bayar: Number(info.f_bayar[x].replace(/[\,]/g, '')),
                f_bank: info.f_bank[x],
                f_currency: info.f_currency[x],
                f_keterangan: info.f_keterangan,
                f_created_on: new Date(),
                f_created_by: req.session.user,
                'f_delete_status': 'No',
                'f_delete_on': '',
                'f_delete_by': ''
            }];
            db.collection('t_metode_pembayaran').insert(vDataMetode, {
                safe: true
            }, function(err, result) {});
        }
        res.send(JSON.stringify({
            success: true,
            message: 'Success Add'
        }));
    } else {
        res.send(JSON.stringify({
            success: false,
            message: 'Access denied'
        }));
    }
};
var now = new Date();
var period = dateFormat(now, "yymm");

function insert_jamaah(idproduk, kodebooking, seatbooking, biayabooking, total_tagihan, req, res) {
    db.collection('t_series_no').find({
        'f_series_code': 'JMH'
    }).toArray(function(err, resultSeries) {
		var tagihan_jamaah = parseFloat(total_tagihan/seatbooking);
		var sisa_tagihan_jamaah = tagihan_jamaah - biayabooking;
        for (i = 0; i < seatbooking; i++) {
            var nourut = Number(resultSeries[0]['f_series_last_no']) + Number(i);
            var series = 'JMH' + period + nourut;
            var vData = [{
                "f_id_produk": ObjectId(idproduk),
                "f_kode_flight": "",
                "f_kode_booking": kodebooking,
                "f_kode_jamaah": series,
                "f_status_jamaah": 'Booked',
                "f_status_bayar": 'Belum Lunas',
                "f_room": '',
                "f_nama_jamaah": 'No Name',
                "f_gender": '',
                "f_tempat_lahir": '',
                "f_tgl_lahir": '',
                "f_hp": '',
                "f_email": '',
                "f_hubungan": '',
                "f_alamat": '',
                "f_catatan": '',
                "f_hubungan": '',
                "f_group": '',
                "f_passport": "",
                "f_passport3kata": "",
                "f_photo": "",
                "f_meningitis": "",
                "f_mahrom": "",
                "f_ktp": "",
                "f_nik_ktp": "",
                "f_kategori_usia": "",
                "f_kartu_keluarga": "",
                "f_surat_nikah": "",
                "f_akta_lahir": "",
                "f_no_passport": '',
                "f_kota_rilis_passport": '',
                "f_tgl_rilis_passport": '',
                "f_tgl_expired_passport": '',
                "f_addon": '',
                "f_kelas_bisnis": '',
                "f_guide_dorong": '',
                "f_guide_khusus": '',
                "f_sharing_bed": '',
                "f_infant": '',
                "f_tiket_id": '',
                "f_jml_tagihan": tagihan_jamaah,
                "f_jml_sisa_tagihan": parseFloat(sisa_tagihan_jamaah),
                "f_jamaah_dompet" :0,
                "f_last_latitude": '',
                "f_last_longitude": '',
                "f_last_datetime_position": new Date(),
                "f_created_on": new Date(),
                "f_created_by": '',
                "f_updated_on": '',
                "f_updated_by": ''
            }];
            db.collection('t_master_data_jamaah').insert(vData, {
                safe: true
            }, function(err, result) {
                if (err) {} else {}
            });
            db.get().collection('t_series_no').update({
                'f_series_code': 'JMH'
            }, {
                $set: {
                    'f_series_last_no': Number(resultSeries[0]['f_series_last_no']) + Number(seatbooking)
                }
            }, function(err, result) {})
            insert_invoice(idproduk, kodebooking, series, biayabooking, req, res)
        };
    })
}

function insert_invoice(idproduk, kodebooking, kodejamaah, biayabooking, req, res) {
    db.collection('t_booking').find({
        'f_kode_booking': kodebooking
    }).toArray(function(err, resultBooking) {
        var vbiaya;
        for (i = 0; i < resultBooking[0]['f_biaya_lain'].length; i++) {
            if (resultBooking[0]['f_biaya_lain'][i]['f_kode'] == 'Paket') {
                vbiaya = Number(resultBooking[0]['f_biaya_lain'][i]['f_amount']) - Number(biayabooking);
            } else {
                vbiaya = Number(resultBooking[0]['f_biaya_lain'][i]['f_amount']);
            }
            var vData = [{
                f_kode_booking: kodebooking,
                f_kode_jamaah: kodejamaah,
                f_kode_biaya: resultBooking[0]['f_biaya_lain'][i]['f_kode'],
                f_deskripsi: resultBooking[0]['f_biaya_lain'][i]['f_name'],
                f_currency: resultBooking[0]['f_biaya_lain'][i]['f_currency'],
                f_biaya: Number(resultBooking[0]['f_biaya_lain'][i]['f_amount']),
                f_jml_sisa_tagihan: Number(vbiaya),
                f_created_on: new Date(),
                f_created_by: req.session.user
            }];
            db.collection('t_invoice').insert(vData, {
                safe: true
            }, function(err, result) {
                if (err) {} else {}
            });
        };
    })
}

function update_komisi_prospek(kodebooking,hp,jmlbooking, req, res) {
  console.log( 'cek===============')

  db.collection('t_prospek').find({'f_hp':hp,f_status:'Aktif'}).toArray(function(err, resultdata) {
    console.log(resultdata + '===============')
        if (resultdata.length > 0) {
            db.collection('t_booking').updateOne({
                'f_kode_booking': kodebooking
            }, {
                $set: {
                    f_komisi_prospek: Number('250000')*Number(jmlbooking),
                    f_user_agen_id : ObjectId(resultdata[0]['f_createdId_by'])
                }
            }, function(err, result) {})
        }else{

        }
    })

}

function insert_jamaah___(idproduk, kodebooking, seatbooking, req, res) {
    new Promise(function(resolve, reject) {
        for (i = 0; i < seatbooking; i++) {
            console.log(i + 'bisaaa')
            setTimeout(() => resolve(insJamaah(i, idproduk, kodebooking, seatbooking, req, res)), 0);
        }
    }).then(function(resultfirts) {})
}

function insJamaah(no, idproduk, kodebooking, seatbooking, req, res) {
    return new Promise((resolve, reject) => {
        // console.log(no + "Nnnnnn")
        setTimeout(function() {
            // console.log(no + "NOOOOOO")
            //mseriesno.fnget_seriesno('JMH', function(err, vseriesno) {
            db.collection('t_series_no').find({
                'f_series_code': 'JMH'
            }).toArray(function(err, resultSeries) {
                var series = 'JMH' + period + Number(resultSeries[0]['f_series_last_no']) + 1;
                // console.log(resultSeries + new Date())
                // console.log(series + new Date())
                var vData = [{
                    "f_id_produk": ObjectId(idproduk),
                    "f_kode_flight": "",
                    "f_kode_booking": kodebooking,
                    "f_kode_jamaah": series,
                    "f_room": '',
                    "f_nama_jamaah": 'No Name',
                    "f_gender": '',
                    "f_tempat_lahir": '',
                    "f_tgl_lahir": '',
                    "f_hp": '',
                    "f_email": '',
                    "f_hubungan": '',
                    "f_alamat": '',
                    "f_catatan": '',
                    "f_hubungan": '',
                    "f_group": '',
                    "f_passport": "",
                    "f_passport3kata": "",
                    "f_photo": "",
                    "f_meningitis": "",
                    "f_mahrom": "",
                    "f_ktp": "",
                    "f_nik_ktp": "",
                    "f_kategori_usia": "",
                    "f_kartu_keluarga": "",
                    "f_surat_nikah": "",
                    "f_akta_lahir": "",
                    "f_no_passport": '',
                    "f_kota_rilis_passport": '',
                    "f_tgl_rilis_passport": '',
                    "f_tgl_expired_passport": '',
                    "f_addon": '',
                    "f_kelas_bisnis": '',
                    "f_guide_dorong": '',
                    "f_guide_khusus": '',
                    "f_sharing_bed": '',
                    "f_infant": '',
                    "f_tiket_id": '',
                    "f_jml_tagihan": '',
                    "f_jml_sisa_tagihan": '',
                    "f_last_latitude": '',
                    "f_last_longitude": '',
                    "f_last_datetime_position": new Date(),
                    "f_created_on": new Date(),
                    "f_created_by": '',
                    "f_updated_on": '',
                    "f_updated_by": ''
                }];
                db.collection('t_master_data_jamaah').insert(vData, {
                    safe: true
                }, function(err, result) {
                    if (err) {} else {
                        // db.collection('t_series_no').find({'f_series_code':'JMH'}).toArray(function(err, resultSeries) {
                        console.log(Number(resultSeries[0]['f_series_last_no']) + 1)
                        db.get().collection('t_series_no').updateOne({
                            'f_series_code': 'JMH'
                        }, {
                            $set: {
                                'f_series_last_no': Number(resultSeries[0]['f_series_last_no']) + 1
                            }
                        }, function(err, result) {})
                        // })
                        //           resolve(result)
                    }
                });
            });
        }, 2000);
    })
}
exports.insert = function(req, res) {
    if (req.session.akses.add == 1) {
        var info = req.body;
		var kodebooking = info.f_kode_booking;
		var keteragan = info.f_keterangan;
		var total_bayar = 0;
		console.log(info)
		asyncjs.waterfall([
			function(c) {
				for (i = 0; i < info.f_kode_jamaah.length; i++) {
					if (info.f_jml_bayar[i] != '') {
						console.log(info.f_kode_jamaah[i])
	                    const kodeinvoice = info.f_kode_invoice[i];
	                    const kodejamaah = info.f_kode_jamaah[i];
	                    const kodebayar = info.f_kode_bayar;
	                    const kodebiaya = info.f_kode_biaya[i];
	                    const namabiaya = info.f_nama_biaya[i];
	                    const sisabiaya = info.f_jml_sisa_tagihan[i].replace(/[\,]/g, '');
	                    const biaya = info.f_biaya[i].replace(/[\,]/g, '');
	                    const bayar = info.f_jml_bayar[i].replace(/[\,]/g, '');
	                    total_bayar += parseInt(bayar);
	                    var opt_jam = [
							{
							        $lookup: {
							            from: 't_booking',
							            localField: 'f_kode_booking',
							            foreignField: 'f_kode_booking',
							            as: 'booking'
							        }
							},
							{ $unwind : '$booking'},
							{ $match : { f_kode_jamaah : info.f_kode_jamaah[i] , f_kode_booking : info.f_kode_booking } }
						];
						console.log(opt_jam)
	                    db.collection("t_master_data_jamaah").aggregate(opt_jam)
	                    .toArray(function(err, resultJam) {
							//console.log('kodejamaah ' +kodejamaah)
							//console.log('kodejamaah ' +kodejamaah)
							//console.log('kodejamaah ' +info.f_kode_jamaah[i])
							//console.log('kodejamaah ' +resultJam[0].f_kode_jamaah);
	                        //db.collection("t_master_data_jamaah").find({
	                            //f_kode_jamaah: kodejamaah
	                        //}).toArray(function(err, resultJ) {
	                            //var inittagihanbooking = resultB[0]['f_jml_sisa_tagihan'];
	                            //var inittagihanjamaah = resultJ[0]['f_jml_sisa_tagihan'];
	                            //var lasttagihanbooking = Number(inittagihanbooking) - Number(bayar.replace(/[\,]/g, ''));
	                            //var lasttagihanjamaah = Number(inittagihanjamaah) - Number(bayar.replace(/[\,]/g, ''));
	                            var inittagihanbooking = resultJam[0].booking.f_jml_sisa_tagihan;
	                            var inittagihanjamaah = resultJam[0].f_jml_sisa_tagihan;
	                            var lasttagihanbooking = Number(inittagihanbooking) - Number(bayar.replace(/[\,]/g, ''));
	                            var lasttagihanjamaah = Number(inittagihanjamaah) - Number(bayar.replace(/[\,]/g, ''));
								//console.log('inittagihanbooking ' +inittagihanbooking);
								//console.log('inittagihanjamaah ' +inittagihanjamaah);
	                            var vData = [{
	                                f_id_produk: ObjectId(info.f_id_paket),
	                                f_kode_booking: kodebooking,
	                                f_kode_jamaah: kodejamaah,
	                                f_kode_invoice: kodeinvoice,
	                                f_kode_bayar: kodebayar,
	                                f_kode_biaya: kodebiaya,
	                                f_nama_biaya: namabiaya,
	                                f_jml_biaya: parseFloat(biaya),
	                                f_jml_sisa_tagihan_biaya: parseFloat(sisabiaya),
	                                f_init_sisa_tagihan_jamaah: inittagihanjamaah,
	                                f_init_sisa_tagihan_booking: inittagihanbooking,
	                                f_jml_bayar: parseFloat(bayar),
	                                f_last_sisa_tagihan_jamaah: lasttagihanjamaah,
	                                f_last_sisa_tagihan_booking: lasttagihanbooking,
	                                f_created_on: new Date(),
	                                f_created_by: req.session.user,
	                                'f_delete_status': 'No',
	                                'f_delete_on': '',
	                                'f_delete_by': ''
	                            }];
	                            console.log('vData')
	                            console.log(vData)
	                            // Insert Pembayaran
	                            db.collection('t_pembayaran').insert(vData, { safe: true }, function(err, result) {});
	                            // update jamaah
	                            var status_jamaah = "Booked";
	                            var status_bayar = "Belum Lunas";
	                            if(parseFloat(lasttagihanjamaah) < 1) {
		                            status_jamaah = "Lunas";
		                            status_bayar = "Lunas";
								}
								//console.log('kode jamaah '+ kodejamaah)
	                            db.collection('t_master_data_jamaah').updateOne({f_kode_jamaah: kodejamaah },
		                            { $set: { 'f_jml_sisa_tagihan': parseFloat(lasttagihanjamaah), f_status_jamaah : status_jamaah, f_status_bayar: status_bayar } },
	                            function(err, resultUpdate) {});
	                            //// update invoice
	                            var vcal = Number(sisabiaya) - Number(bayar);
	                            db.collection('t_invoice').updateOne({'_id': { $eq: ObjectId(kodeinvoice) } },
		                            { $set: { 'f_jml_sisa_tagihan': Number(vcal) } },
	                            function(err, resultUpdate) {
	                                ////if (resultUpdate) {
	                                    ////var vquery = [{
	                                        ////$match: {
	                                            ////'f_kode_jamaah': kodejamaah
	                                        ////}
	                                    ////}, {
	                                        ////$group: {
	                                            ////_id: {
	                                                ////'f_kode_jamaah': '$f_kode_jamaah'
	                                            ////},
	                                            ////'sum_tagihan': {
	                                                ////'$sum': '$f_jml_sisa_tagihan'
	                                            ////},
	                                        ////},
	                                    ////}]
	                                    ////db.get().collection('t_invoice').aggregate(vquery).toArray(function(err, resulttagihan) {
	                                        ////var vstatus;
	                                        ////console.log(resulttagihan[0]['sum_tagihan'])
	                                        ////if (Number(resulttagihan[0]['sum_tagihan']) < 1) {
	                                            ////db.collection('t_master_data_jamaah').updateOne({
	                                                ////'f_kode_jamaah': kodejamaah
	                                            ////}, {
	                                                ////$set: {
	                                                    ////f_status_jamaah: 'Lunas'
	                                                ////}
	                                            ////}, function(err, result) {})
	                                            //////update_status(kodebooking, req, res)
	                                        ////}
	                                    ////})
	                                ////} // end if resultUpdate									
								}); // end t_invoice
							//}); // end t_master_data_jamaah
						});	// end t_master_data_jamaah //t_booking
					} // end if info.f_jml_bayar
				} // end for
				return c(null);
			},
			function(c) {
			    db.collection('t_booking').findOne({
			        f_kode_booking: info.f_kode_booking
			    }, function(err, item) {
					var status = 'Booked';
					var sisa_tagihan = parseFloat(item.f_jml_sisa_tagihan) - parseFloat(total_bayar);
					if(sisa_tagihan < 1) status = 'Lunas';
					db.collection('t_booking').updateOne({f_kode_booking: kodebooking },
						{ $set: { f_status : status,'f_jml_sisa_tagihan': parseFloat(sisa_tagihan) } },
					function(err, r) {
						return c(null);
					});
			    });				
			}
		], function() {
	        for (x = 0; x < info.f_bayar.length; x++) {
	            var vDataMetode = [{
	                f_id_produk: ObjectId(info.f_id_paket),
	                f_tgl_bayar: info.f_tgl_bayar,
	                f_kode_booking: info.f_kode_booking,
	                f_kode_bayar: info.f_kode_bayar,
	                f_metode_bayar: info.f_metode_bayar[x],
	                f_total_bayar: Number(info.f_bayar[x].replace(/[\,]/g, '')),
	                f_bank: info.f_bank[x],
	                f_currency: info.f_currency[x],
	                f_keterangan: info.f_keterangan,
	                f_created_on: new Date(),
	                f_created_by: req.session.user,
	                'f_delete_status': 'No',
	                'f_delete_on': '',
	                'f_delete_by': ''
	            }];
	            db.collection('t_metode_pembayaran').insert(vDataMetode, {
	                safe: true
	            }, function(err, result) {});
	        }
	
	        db.collection("t_booking").find({
	            f_kode_booking: info.f_kode_booking
	        }).toArray(function(err, resultBo) {
	          db.collection('t_template_wa').findOne({
	              kode_wa: 'NOTIF6'
	          }, function(err, msgwa) {
	              sender_wa.fnSender(resultBo[0]['f_hp'], msgwa['content_wa']);
	          });
	        })
	
	        res.send(JSON.stringify({
	            success: true,
	            message: 'Success Add'
	        }));			
		});
    } else {
        res.send(JSON.stringify({
            success: false,
            message: 'Access denied'
        }));
    }
};

function update_status(kodebooking, req, res) {
    var vquery = [{
        $match: {
            'f_kode_booking': kodebooking
        }
    }, {
        $group: {
            _id: {
                'f_kode_booking': '$f_kode_booking'
            },
            'sum_tagihan': {
                '$sum': '$f_jml_sisa_tagihan'
            },
        },
    }]
    db.collection('t_invoice').aggregate(vquery).toArray(function(err, resultInvoice) {
        if (Number(resultInvoice[0]['sum_tagihan']) < 1) {
            db.collection('t_booking').updateOne({
                'f_kode_booking': kodebooking
            }, {
                $set: {
                    f_status: 'Lunas'
                }
            }, function(err, result) {

            })
        }else{

        }
    })

}

function fnupdateTagihanBooking(kode_booking, kode_jamaah, sisa_tagihan_booking, sisa_tagihan_jamaah) {
    // db.collection('t_booking').updateOne({
    //     'f_kode_booking': kode_booking
    // }, {
    //     $set: {
    //         f_jml_sisa_tagihan: Number(sisa_tagihan_booking)
    //     }
    // }, function(err, result) {});
    // // db.collection('t_master_data_jamaah').updateOne({
    // //     'f_kode_jamaah': kode_jamaah
    // // }, {
    // //     $set: {
    // //         f_jml_sisa_tagihan: Number(sisa_tagihan_jamaah)
    // //     }
    // // }, function(err, result) {});
}

function fnupdateTagihan_(kode_bayar, kode_booking, kode_jamaah, sisa_tagihan) {
    db.collection("t_pembayaran").find({
        f_kode_bayar: kode_bayar,
        f_kode_jamaah: kode_jamaah
    }).toArray(function(err, result) {
        var datasumbooking = [];
        var datasumjamaah = [];
        result.forEach(function(row) {
            datasumbooking.push(Number(row.f_jml_bayar))
            if (row.f_kode_jamaah == kode_jamaah) {
                datasumjamaah.push(Number(row.f_jml_bayar))
            }
        })
        if (datasumbooking.length > 0) {
            var vsumbooking = datasumbooking.reduce(getSum);
            var vsumjamaah = datasumjamaah.reduce(getSum);
        }
        // console.log(sisa_tagihan + "sisa")
        // console.log(vsumjamaah + "sum")
        var vcal = Number(sisa_tagihan) - Number(vsumjamaah);
        var vdatatagihan = {
            f_jml_sisa_tagihan: vcal,
        }
        // db.collection('t_master_data_jamaah').updateOne({
        //     'f_kode_jamaah': kode_jamaah
        // }, {
        //     $set: vdatatagihan
        // }, function(err, result) {});
    });
}

function getSum(total, num) {
    return total + num;
}
exports.update = function(req, res) {
    if (req.session.akses.edit == 1) {
        var info = req.body;
        var vData = {
            f_id_produk: info.f_id_produk,
            f_kode_booking: info.f_kode_booking,
            f_kode_jamaah: info.f_kode_jamaah,
            f_kode_bayar: info.f_kode_bayar,
            f_nama_biaya: info.f_nama_biaya,
            f_jml_biaya: info.f_jml_biaya,
            f_jml_bayar: info.f_jml_bayar,
            f_updated_on: dateFormat(Date(), 'yyyy-mm-dd HH:MM:ss'),
            f_updated_by: req.session.user
        };
        db.collection('t_pembayaran').updateOne({
            '_id': {
                $eq: ObjectId(req.param('_id'))
            }
        }, {
            $set: vData
        }, function(err, result) {
            if (err) {
                res.send(JSON.stringify({
                    success: false,
                    message: 'Error Edit'
                }));
            } else {
                res.send(JSON.stringify({
                    success: true,
                    message: 'Success Edit'
                }));
            }
        });
    } else {
        res.send(JSON.stringify({
            success: false,
            message: 'Access denied'
        }));
    }
};
exports.delete = function(req, res) {
    if (req.session.akses.del == 1) {
        db.collection('t_metode_pembayaran').updateMany({
            'f_kode_bayar': {
                $eq: req.param('kodebayar')
            }
        }, {
            $set: {
                'f_delete_status': 'Yes',
                'f_delete_on': new Date(),
                'f_delete_by': req.session.user
            }
        }, function(err, result) {
            if (err) {
                res.send(JSON.stringify({
                    success: false,
                    message: 'Error Edit'
                }));
            } else {
                res.send(JSON.stringify({
                    success: true,
                    message: 'Success Delete'
                }));
                fnDeletePembayaran(req.param('kodebayar'), req, res);
            }
        });
    } else {
        res.send(JSON.stringify({
            success: false,
            message: 'Access denied'
        }));
    }
};

function fnDeletePembayaran(kodebayar, req, res) {
    db.collection('t_pembayaran').find({
        'f_kode_bayar': kodebayar
    }).toArray(function(err, resultdata) {
        var i = 0;
        resultdata.forEach(function(row) {
            if (row['f_kode_biaya'] != 'Booking') {
                db.collection('t_invoice').findOne({
                    '_id': ObjectId(row['f_kode_invoice'])
                }, function(err, resultinvoice) {
                    var reversebalance = parseFloat(resultinvoice['f_jml_sisa_tagihan']) + parseFloat(row['f_jml_bayar'])
                    db.collection('t_invoice').updateOne({
                        'f_kode_invoice': {
                            $eq: row['f_kode_invoice']
                        }
                    }, {
                        $set: {
                            'f_jml_sisa_tagihan': reversebalance
                        }
                    }, function(err, result) {
                        if (i == resultdata.length) {
                            db.collection('t_pembayaran').updateOne({
                                'f_kode_bayar': {
                                    $eq: kodebayar
                                }
                            }, {
                                $set: {
                                    'f_delete_status': 'Yes',
                                    'f_delete_on': new Date(),
                                    'f_delete_by': req.session.user
                                }
                            }, function(err, result) {});
                        }
                    });
                });
            } else {
                db.collection('t_invoice').findOne({
                    'f_kode_booking': row['f_kode_booking'],
                    f_kode_biaya: 'Booking'
                }, function(err, resultinvoice) {
                    var reversebalance = parseFloat(resultinvoice['f_jml_sisa_tagihan']) + parseFloat(row['f_jml_bayar'])
                    db.collection('t_invoice').updateOne({
                        'f_kode_booking': {
                            $eq: row['f_kode_booking']
                        },
                        f_kode_biaya: 'Booking'
                    }, {
                        $set: {
                            'f_jml_sisa_tagihan': reversebalance
                        }
                    }, function(err, result) {
                        if (i == resultdata.length) {
                            db.collection('t_pembayaran').updateOne({
                                'f_kode_bayar': {
                                    $eq: kodebayar
                                }
                            }, {
                                $set: {
                                    'f_delete_status': 'Yes',
                                    'f_delete_on': new Date(),
                                    'f_delete_by': req.session.user
                                }
                            }, function(err, result) {});
                        }
                    });
                });
            }
            i++;
        })
    });
}
exports.historypembayaran = function(req, res) {
    var info = req.query;
    var vquery = [{
        $match: {
            // _id: ObjectId(info.id)
            f_kode_booking: info.id
        }
    }, {
        $group: {
            '_id': {
                '_id': '$_id',
                'f_id_produk': '$f_id_produk',
                'f_produk': '$f_produk',
                'f_kode_bayar': '$f_kode_bayar',
                'f_kode_booking': '$f_kode_booking',
                'f_tgl_bayar': '$f_tgl_bayar',
                'f_metode_bayar': '$f_metode_bayar',
                'f_total_bayar': '$f_total_bayar',
                'f_keterangan': '$f_keterangan',
                'f_bank': '$f_bank',
            }
        }
    }, {
        $lookup: {
            from: 't_produk',
            localField: '_id.f_id_produk',
            foreignField: '_id',
            as: 'f_produk_detail'
        }
    }, {
        $lookup: {
            from: 't_booking',
            localField: '_id.f_kode_booking',
            foreignField: 'f_kode_booking',
            as: 'booking_detail'
        }
    }, {
        $lookup: {
            from: 't_master_data_jamaah',
            localField: '_id.f_kode_booking',
            foreignField: 'f_kode_booking',
            as: 'master_detail'
        }
    }]
    db.collection('t_metode_pembayaran').aggregate(vquery).toArray(function(err, result) {
        console.log(result);
        var vars = {
            title: 'Detail History Pembayaran',
            subtitle: 'History Pembayaran',
            module: 'md_pembayaran_jamaah',
            act: 'historypembayaran',
            kodebooking: info.id,
            result: result,
        };
        res.render(__dirname + '/../views/vw_history.html', vars);
    });
};
exports.dataHistory = function(req, res) {
    var info = req.query;
    var vquery = []
    vquery.push({
        $match: {
            'f_delete_status': 'No',
            'f_kode_booking': req.param('kodebooking')
        }
    }, {
        $sort: {
            '_id': -1
        }
    }, {
        $group: {
            _id: {
                //                    _id: '$_id',
                f_kode_booking: '$f_kode_booking',
                f_tgl_bayar: '$f_tgl_bayar',
                f_kode_bayar: '$f_kode_bayar',
                //                    f_metode_bayar: '$f_metode_bayar',
                //                    f_bank: '$f_bank',
                //                    f_currency: '$f_currency',
                //                    f_total_bayar: '$f_total_bayar',
                f_keterangan: '$f_keterangan',
                f_created_by: '$f_created_by',
                //                    f_created_on: '$f_created_on',
            },
            f_total_bayar: {
                $sum: '$f_total_bayar'
            },
        }
    }, {
        $lookup: {
            from: 't_booking',
            localField: '_id.f_kode_booking',
            foreignField: 'f_kode_booking',
            as: 'booking_detail'
        }
    }, {
        $lookup: {
            from: 't_produk',
            localField: 'booking_detail.f_id_produk',
            foreignField: '_id',
            as: 'produk_detail'
        }
    }, {
        $project: {
            //                _id: '$_id._id',
            f_kode_booking: '$_id.f_kode_booking',
            f_tgl_bayar: '$_id.f_tgl_bayar',
            f_kode_bayar: '$_id.f_kode_bayar',
            //                f_metode_bayar: '$_id.f_metode_bayar',
            //                f_bank: '$_id.f_bank',
            //                f_currency: '$_id.f_currency',
            f_total_bayar: '$f_total_bayar',
            f_keterangan: '$_id.f_keterangan',
            f_operator: '$_id.f_created_by',
            //                f_created_on: '$_id.f_created_on',
        }
    })
    db.get().collection('t_metode_pembayaran').count({}, function(err, resultcount) {
        db.get().collection('t_metode_pembayaran').aggregate(vquery).toArray(function(err, result) {
            console.log(result);
            //      if (err) return callback(err);
            var vresult;
            var draw;
            if (result == undefined) {
                vresult = []
            } else {
                vresult = result
            }
            var djson = {
                draw: req.param('draw'),
                recordsTotal: resultcount,
                recordsFiltered: resultcount,
                data: vresult
            }
            res.json(djson);
        })
    })
};
exports.printslip = function(req, res) {
    var info = req.query;
    var vquery = [{
        $match: {
            // _id: ObjectId(info.id)
            f_kode_bayar: info.id
        }
    }, {
        $group: {
            '_id': {
                '_id': '$_id',
                'f_id_produk': '$f_id_produk',
                'f_produk': '$f_produk',
                'f_kode_bayar': '$f_kode_bayar',
                'f_kode_booking': '$f_kode_booking',
                'f_tgl_bayar': '$f_tgl_bayar',
                'f_metode_bayar': '$f_metode_bayar',
                'f_total_bayar': '$f_total_bayar',
                'f_keterangan': '$f_keterangan',
                'f_bank': '$f_bank',
            }
        }
    }, {
        $lookup: {
            from: 't_produk',
            localField: '_id.f_id_produk',
            foreignField: '_id',
            as: 'f_produk_detail'
        }
    }, {
        $lookup: {
            from: 't_booking',
            localField: '_id.f_kode_booking',
            foreignField: 'f_kode_booking',
            as: 'booking_detail'
        }
    }, {
        $lookup: {
            from: 't_master_data_jamaah',
            localField: '_id.f_kode_booking',
            foreignField: 'f_kode_booking',
            as: 'master_detail'
        }
    }]
    db.collection('t_metode_pembayaran').aggregate(vquery).toArray(function(err, result) {
        console.log(result);
        var datasum = [];
        result.forEach(function(row) {
            datasum.push(Number(row._id.f_total_bayar))
        })
        if (datasum.length > 0) {
            var vsum = datasum.reduce(getSum);
        }
        var vars = {
            title: 'Slip Pembayaran',
            subtitle: 'Slip Pembayaran',
            module: 'md_pembayaran_jamaah',
            act: 'printslip',
            user: req.session.user,
            per: req.session,
            result: result,
            vsum: vsum
        };
        res.render(__dirname + '/../views/vw_slip.html', vars);
    });
};
