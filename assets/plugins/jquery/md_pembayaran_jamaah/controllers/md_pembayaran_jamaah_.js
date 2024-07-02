var db = require('../../../database')
var MongoClient = require('mongodb').MongoClient
var ObjectId = require('mongodb').ObjectID;
var bodyParser = require('body-parser');
var dateFormat = require('dateformat');
var MDTable = require('mongo-datatable');
var mseriesno 	= require("../../../modules/md_series_no/controllers/md_series_no.js");

exports.fnseriesno = function(req, res) {
	mseriesno.fnget_seriesno('BYR', function (err, vseriesno) {
		res.json({f_kode_bayar : vseriesno});
	})
	mseriesno.fnupdate_seriesno('BYR')
}


exports.index = function(req, res) {
	if(req.session.akses.view)
	{
		var vars = {
				title : 'Pembayaran Jamaah',
				subtitle : '',
				};
		vars.button = req.session.akses;
		res.render(__dirname+'/../views/vw_data.html', vars);
	}	else	{	res.render('accessdenied');	}
};

exports.bayar_booking = function(req, res) {
		var info = req.query;
		var vquery = [
			{$match : {_id:ObjectId(info.id)}},
			{$group : {'_id':{'_id':'$_id','f_produk':'$f_id_produk','f_kode_booking':'$f_kode_booking','f_booking_date':'$f_booking_date','f_nama_pendaftar':'$f_nama_pendaftar','f_hp':'$f_hp','f_email':'$f_email','f_jml_seat_booking':'$f_jml_seat_booking'}}},
			{ $lookup:
				{
					from: 't_produk',
					localField: '_id.f_produk',
					foreignField: '_id',
					as: 'f_produk_detail'
				}
			}
		]
			db.collection('t_booking_umroh').aggregate(vquery).toArray(function(err, result) {
				var vars = {
						title 			: 'Form Pembayaran Booking Jamaah',
						subtitle 		: '',
						module 		 	: 'md_pembayaran_jamaah',
						act 			 	: 'bayar',
						result 		 	: result,
						};
						res.render(__dirname+'/../views/vw_form_booking.html', vars);
			});

};
exports.bayar = function(req, res) {
		var info = req.query;
		var vquery = [
			{$match : {_id:ObjectId(info.id)}},
			{$group : {'_id':{'_id':'$_id','f_produk':'$f_id_produk','f_kode_booking':'$f_kode_booking','f_booking_date':'$f_booking_date','f_nama_pendaftar':'$f_nama_pendaftar','f_hp':'$f_hp','f_email':'$f_email','f_jml_seat_booking':'$f_jml_seat_booking'}}},
			{ $lookup:
				{
					from: 't_produk',
					localField: '_id.f_produk',
					foreignField: '_id',
					as: 'f_produk_detail'
				}
			}
		]
			db.collection('t_booking_umroh').aggregate(vquery).toArray(function(err, result) {
				var vars = {
						title 			: 'Form Pembayaran Jamaah',
						subtitle 		: '',
						module 		 	: 'md_pembayaran_jamaah',
						act 			 	: 'bayar',
						result 		 	: result,
						};
						res.render(__dirname+'/../views/vw_form.html', vars);
			});

};
exports.data_booking = function(req, res) {
  var vquery = []
		vquery.push({$match:{f_kode_booking : req.param('kodebooking')}});
    vquery.push(
      {$sort:{'_id':-1}},
      {$group :
      {_id :
        {
					"_id"										: '$_id',
					"f_id_produk"						: '$f_id_produk',
					"f_kode_flight"					: "",
					"f_kode_booking"				: '$f_kode_booking',
					"f_created_on"					: new Date(),
					"f_created_by"					: req.session.user
        }
      }
    },
    {
      $lookup: {
          from: 't_invoice',
          localField: '_id.f_kode_booking',
          foreignField: 'f_kode_booking',
          as: 'biaya_detail'
      }
    },

    {
     $project:{
			   "_id"										: "$_id._id",
				 "f_id_produk"						: '$_id.f_id_produk',
				 "f_kode_flight"					: "",
				 "f_kode_booking"					: '$_id.f_kode_booking',
				 "f_biaya_detail"					: '$biaya_detail',
				 "f_created_on"						: '$_id.f_created_on',
				 "f_created_by"						: '$_id.f_created_by'
     }
   })
   db.get().collection('t_booking_umroh').count({}, function(err, resultcount) {
    db.get().collection('t_booking_umroh').aggregate(vquery).toArray(function(err, result) {
//      if (err) return callback(err);
      var djson = {
        draw 						: req.param('draw'),
        recordsTotal 		: resultcount,
        recordsFiltered	:	resultcount,
        data : result
      }
      res.json(djson);
    })
  })
};

exports.data_jamaah = function(req, res) {
  var vquery = []
		vquery.push({$match:{f_kode_booking : req.param('kodebooking')}});
    vquery.push(
      {$sort:{'_id':-1}},
      {$group :
      {_id :
        {
					"_id"										: '$_id',
					"f_id_produk"						: '$f_id_produk',
					"f_kode_flight"					: "",
					"f_kode_booking"				: '$f_kode_booking',
					"f_room"								: '$f_room',
					"f_kode_jamaah"					: '$f_kode_jamaah',
					"f_nama_jamaah"					: '$f_nama_jamaah',
					"f_gender"							: '$f_gender',
					"f_tempat_lahir"				: '$f_tempat_lahir',
					"f_tgl_lahir"						: '$f_tgl_lahir',
					"f_hp"									: '$f_hp',
					"f_email"								: '$f_email',
					"f_alamat"							: '$f_alamat',
					"f_catatan"							: '$f_catatan',
					"f_berkas"							: '$f_berkas',
					"f_group"								: '$f_kode_group_family',
					"f_no_passport"					: '$f_no_passport',
					"f_kota_rilis_passport"	: '$f_kota_rilis_passport',
					"f_tgl_rilis_passport"	: '$f_tgl_rilis_passport',
					"f_tgl_expired_passport": '$f_tgl_expired_passport',
					"f_addon"								: '$f_addon',
					"f_kelas_bisnis"				: '$f_kelas_bisnis',
 				 "f_guide_dorong"				  : '$f_guide_dorong',
 				 "f_guide_khusus"				  : '$f_guide_khusus',
					"f_sharing_bed"					: '$f_sharing_bed',
					"f_infant"							: '$f_infant',
					"f_tiket_id"						: '$f_tiket_id',
					"f_jml_tagihan"					: '$f_jml_tagihan',
					"f_jml_sisa_tagihan"		: '$f_jml_sisa_tagihan',
					"f_created_on"					: new Date(),
					"f_created_by"					: req.session.user
        }
      }
    },
    {
      $lookup: {
          from: 't_invoice',
          localField: '_id.f_kode_jamaah',
          foreignField: 'f_kode_jamaah',
          as: 'biaya_detail'
      }
    },

    {
     $project:{
			   "_id"										: "$_id._id",
				 "f_id_produk"						: '$_id.f_id_produk',
				 "f_kode_flight"					: "",
				 "f_kode_booking"					: '$_id.f_kode_booking',
				 "f_kode_jamaah"					: '$_id.f_kode_jamaah',
				 "f_room"									: '$_id.f_room',
				 "f_nama_jamaah"					: '$_id.f_nama_jamaah',
				 "f_gender"								: '$_id.f_gender',
				 "f_tempat_lahir"					: '$_id.f_tempat_lahir',
				 "f_tgl_lahir"						: '$_id.f_tgl_lahir',
				 "f_hp"										: '$_id.f_hp',
				 "f_email"								: '$_id.f_email',
				 "f_alamat"								: '$_id.f_alamat',
				 "f_catatan"							: '$_id.f_catatan',
				 "f_berkas"								: '$_id.f_berkas',
				 "f_group"								: '$_id.f_kode_group_family',
				 "f_no_passport"					: '$_id.f_no_passport',
				 "f_kota_rilis_passport"	: '$_id.f_kota_rilis_passport',
				 "f_tgl_rilis_passport"		: '$_id.f_tgl_rilis_passport',
				 "f_tgl_expired_passport"	: '$_id.f_tgl_expired_passport',
				 "f_addon"								: '$_id.f_addon',
				 "f_kelas_bisnis"				  : '$_id.f_kelas_bisnis',
				 "f_guide_dorong"				  : '$_id.f_guide_dorong',
				 "f_guide_khusus"				  : '$_id.f_guide_khusus',
				 "f_sharing_bed"					: '$_id.f_sharing_bed',
				 "f_infant"								: '$_id.f_infant',
				 "f_tiket_id"							: '$_id.f_tiket_id',
				 "f_jml_tagihan"					: '$_id.f_jml_tagihan',
				 "f_jml_sisa_tagihan"			: '$_id.f_jml_sisa_tagihan',
				 "f_biaya_detail"					: '$biaya_detail',
				 "f_created_on"						: '$_id.f_created_on',
				 "f_created_by"						: '$_id.f_created_by'
     }
   })
   db.get().collection('t_master_data_jamaah').count({}, function(err, resultcount) {
    db.get().collection('t_master_data_jamaah').aggregate(vquery).toArray(function(err, result) {
//      if (err) return callback(err);
      var djson = {
        draw 						: req.param('draw'),
        recordsTotal 		: resultcount,
        recordsFiltered	:	resultcount,
        data : result
      }
      res.json(djson);
    })
  })
};


exports.add = function(req, res) {
	if(req.session.akses.add == 1)
	{
		var vars = {
				title : 'From Md_pembayaran_jamaah',
				subtitle : 'input data md_pembayaran_jamaah',
				module : 'md_pembayaran_jamaah',
				act : 'add',
				};
		res.render(__dirname+'/../views/vw_form.html', vars);
	}	else	{	res.render('accessdenied');	}
};

exports.edit = function(req, res) {
	if(req.session.akses.edit == 1)
	{
		var vars = {
				title : 'From Md_pembayaran_jamaah',
				subtitle : 'edit data md_pembayaran_jamaah',
				module : 'md_pembayaran_jamaah',
				id : req.param('id'),
				act : 'edit',
				};
		res.render(__dirname+'/../views/vw_form.html', vars);
	}	else	{	res.render('accessdenied');	}
};

//--------------------------------------------------- connection with db
exports.rowId = function(req, res) {
	var info = req.query;
	db.collection('t_pembayaran').findOne({'_id': ObjectId(info.id)}, function(err, item) {
		if(item) res.send(JSON.stringify(item));
		else res.send(JSON.stringify({ success : false }));
	});
};

exports.data = function(req, res) {
	var options = req.query;
	var csearch = [];
	options.caseInsensitiveSearch = false;
	options.showAlertOnError = true;
	options.customQuery = {};
	if(csearch.length > 0) {
		options.customQuery = csearch.length > 0 ? {$and :csearch } : {}
	}
    new MDTable(db.get()).get('t_pembayaran', options, function(err, result) {
		if (err) return callback(err);
		res.json(result);
    });
};

exports.combodata = function(req, res) {
	var options = req.query;var datacombo = [];
	if(options.q) var regexValue = { f_id_produk :new RegExp('\.*'+options.q+'\.', 'i') };
	else var regexValue = {};
	db.collection('t_pembayaran').find(regexValue).limit(10).toArray(function(err, result) {
		if(result) {
			var i = 0;
			result.forEach(function(items){
				datacombo[i] = {'id':items._id,'text':items.f_id_produk};
				i++;
			});
		}
		res.send(JSON.stringify({ result : datacombo}));
	});
}
exports.insertbooking = function(req, res) {
	if(req.session.akses.add == 1)
	{
		var info = req.body;
		for(i=0;i<1;i++){
			if(info.f_jml_bayar[i] != ''){
				const kodebooking= info.f_kode_booking;
				const kodeinvoice= info.f_kode_invoice[i];
//				const kodejamaah = info.f_kode_jamaah[i];
				const kodebayar = info.f_kode_bayar;
				const namabiaya  = info.f_nama_biaya[i];
				const sisabiaya	 = info.f_jml_sisa_tagihan[i].replace(/[\,]/g, '');
				const biaya 		 = info.f_biaya[i].replace(/[\,]/g, '');
				const bayar 		 = info.f_jml_bayar[i].replace(/[\,]/g, '');

				db.collection("t_booking_umroh").find({f_kode_booking:info.f_kode_booking}).toArray(function(err, resultB) {
//					db.collection("t_master_data_jamaah").find({f_kode_jamaah:kodejamaah}).toArray(function(err, resultJ) {

				var inittagihanbooking = resultB[0]['f_jml_sisa_tagihan'];

				 var lasttagihanbooking = Number(inittagihanbooking) - Number(bayar.replace(/[\,]/g, ''));

					var vData = [{
							f_id_produk 								: ObjectId(info.f_id_paket),
							f_kode_booking 							: kodebooking,
							f_kode_bayar 								: kodebayar,
							f_nama_biaya 								: namabiaya,
							f_jml_biaya 								: parseFloat(biaya),
							f_jml_sisa_tagihan_biaya 		: parseFloat(sisabiaya),
							f_init_sisa_tagihan_booking	: parseFloat(inittagihanbooking),
							f_jml_bayar 								: parseFloat(bayar),
							f_last_sisa_tagihan_booking	: parseFloat(lasttagihanbooking),
							f_created_on								:	new Date(),
							f_created_by								:	req.session.user
					}];
					db.collection('t_pembayaran').insert(vData, {safe:true}, function(err,result){
					});
					var vcal = Number(sisabiaya) - Number(bayar);
					db.collection('t_invoice').updateOne({'_id':{$eq : ObjectId(kodeinvoice)}},{$set:{'f_jml_sisa_tagihan':Number(vcal)}},function(err, result) {});
					//=====Update Tagihan Terakhir per Booking
//					fnupdateTagihanBooking(kodebooking,kodejamaah,lasttagihanbooking,lasttagihanjamaah);
					//=====Update Tagihan Terakhir per jamaah
//					fnupdateTagihanJamaah(kodejamaah,lasttagihanjamaah);
//					console.log(lasttagihanbooking + "booking===")
//					console.log(lasttagihanjamaah + "jamaah===")

//				})
			})

			}
		}
			var vDataMetode = [{
					f_id_produk 				: ObjectId(info.f_id_paket),
					f_tgl_bayar 				: info.f_tgl_bayar,
					f_kode_booking 			: info.f_kode_booking,
					f_kode_bayar 				: info.f_kode_bayar,
					f_metode_bayar 			: info.f_metode_bayar,
					f_total_bayar 			: Number(info.f_total_bayar.replace(/[\,]/g, '')),
					f_bank 							: info.f_bank,
					f_created_on				:	new Date(),
					f_created_by				:	req.session.user
			}];
			db.collection('t_metode_pembayaran').insert(vDataMetode, {safe:true}, function(err,result){
			});

			db.collection('t_booking_umroh').updateOne({'f_kode_booking':{$eq : info.f_kode_booking}},{$set:{'f_status':'Booked'}},function(err, result) {});

			res.send(JSON.stringify({ success : true, message: 'Success Add' }));

	}	else	{	res.send(JSON.stringify({ success : false, message: 'Access denied' }));	}
};

exports.insert = function(req, res) {
	if(req.session.akses.add == 1)
	{
		var info = req.body;
		for(i=0;i<info.f_kode_jamaah.length;i++){
			if(info.f_jml_bayar[i] != ''){
				const kodebooking= info.f_kode_booking;
				const kodeinvoice= info.f_kode_invoice[i];
				const kodejamaah = info.f_kode_jamaah[i];
				const kodebayar = info.f_kode_bayar;
				const namabiaya  = info.f_nama_biaya[i];
				const sisabiaya	 = info.f_jml_sisa_tagihan[i].replace(/[\,]/g, '');
				const biaya 		 = info.f_biaya[i].replace(/[\,]/g, '');
				const bayar 		 = info.f_jml_bayar[i].replace(/[\,]/g, '');
				const keteragan = info.f_keterangan;

				db.collection("t_booking_umroh").find({f_kode_booking:info.f_kode_booking}).toArray(function(err, resultB) {
					db.collection("t_master_data_jamaah").find({f_kode_jamaah:kodejamaah}).toArray(function(err, resultJ) {

				var inittagihanbooking = resultB[0]['f_jml_sisa_tagihan'];
				var inittagihanjamaah = resultJ[0]['f_jml_sisa_tagihan'];

				 var lasttagihanbooking = Number(inittagihanbooking) - Number(bayar.replace(/[\,]/g, ''));
				 var lasttagihanjamaah = Number(inittagihanjamaah) - Number(bayar.replace(/[\,]/g, ''));

					var vData = [{
							f_id_produk 								: ObjectId(info.f_id_paket),
							f_kode_booking 							: kodebooking,
							f_kode_jamaah 							: kodejamaah,
							f_kode_bayar 								: kodebayar,
							f_nama_biaya 								: namabiaya,
							f_jml_biaya 								: biaya,
							f_jml_sisa_tagihan_biaya 		: sisabiaya,
							f_init_sisa_tagihan_jamaah	: inittagihanjamaah,
							f_init_sisa_tagihan_booking	: inittagihanbooking,
							f_jml_bayar 								: bayar,
							f_last_sisa_tagihan_jamaah	: lasttagihanjamaah,
							f_last_sisa_tagihan_booking	: lasttagihanbooking,
							f_created_on								:	new Date(),
							f_created_by								:	req.session.user
					}];
					db.collection('t_pembayaran').insert(vData, {safe:true}, function(err,result){
					});
					var vcal = Number(sisabiaya) - Number(bayar);
					db.collection('t_invoice').updateOne({'_id':{$eq : ObjectId(kodeinvoice)}},{$set:{'f_jml_sisa_tagihan':Number(vcal)}},function(err, result) {});
					//=====Update Tagihan Terakhir per Booking
					fnupdateTagihanBooking(kodebooking,kodejamaah,lasttagihanbooking,lasttagihanjamaah);
					//=====Update Tagihan Terakhir per jamaah
//					fnupdateTagihanJamaah(kodejamaah,lasttagihanjamaah);
					console.log(lasttagihanbooking + "booking===")
					console.log(lasttagihanjamaah + "jamaah===")

				})
			})

			}
		}
			var vDataMetode = [{
					f_id_produk 				: ObjectId(info.f_id_paket),
					f_tgl_bayar 				: info.f_tgl_bayar,
					f_kode_booking 			: info.f_kode_booking,
					f_kode_bayar 				: info.f_kode_bayar,
					f_metode_bayar 			: info.f_metode_bayar,
					f_total_bayar 			: Number(info.f_total_bayar.replace(/[\,]/g, '')),
					f_bank 							: info.f_bank,
					f_keterangan				: keterangan,
					f_created_on				:	new Date(),
					f_created_by				:	req.session.user
			}];
			db.collection('t_metode_pembayaran').insert(vDataMetode, {safe:true}, function(err,result){
			});

			res.send(JSON.stringify({ success : true, message: 'Success Add' }));

	}	else	{	res.send(JSON.stringify({ success : false, message: 'Access denied' }));	}
};
function fnupdateTagihanBooking(kode_booking,kode_jamaah,sisa_tagihan_booking,sisa_tagihan_jamaah){
			db.collection('t_booking_umroh').updateOne({'f_kode_booking': kode_booking},{$set:{f_jml_sisa_tagihan : Number(sisa_tagihan_booking)}},function(err, result) {
			});

			db.collection('t_master_data_jamaah').updateOne({'f_kode_jamaah': kode_jamaah},{$set:{f_jml_sisa_tagihan : Number(sisa_tagihan_jamaah)}},function(err, result) {
			});

}
function fnupdateTagihanJamaah(kode_jamaah,sisa_tagihan){
}

function fnupdateTagihan_(kode_bayar,kode_booking,kode_jamaah,sisa_tagihan){
	db.collection("t_pembayaran").find({f_kode_bayar:kode_bayar,f_kode_jamaah:kode_jamaah}).toArray(function(err, result) {
		var datasumbooking = [];
		var datasumjamaah = [];
		result.forEach(function(row){
			datasumbooking.push(Number(row.f_jml_bayar))
			if(row.f_kode_jamaah == kode_jamaah){
			datasumjamaah.push(Number(row.f_jml_bayar))
			}
		})
		if(datasumbooking.length > 0){
		var vsumbooking = datasumbooking.reduce(getSum);
		var vsumjamaah = datasumjamaah.reduce(getSum);
		}
		console.log(sisa_tagihan + "sisa")
		console.log(vsumjamaah + "sum")

		var vcal = Number(sisa_tagihan) - Number(vsumjamaah);
		var vdatatagihan = {
			f_jml_sisa_tagihan : vcal,
		}

		db.collection('t_master_data_jamaah').updateOne({'f_kode_jamaah': kode_jamaah},{$set:vdatatagihan},function(err, result) {
		});
	});

}
function getSum(total, num) {
  return total + num;
}

exports.update = function(req, res) {
	if(req.session.akses.edit == 1)
	{
		var info = req.body;
		var vData = {
			f_id_produk : info.f_id_produk,
			f_kode_booking : info.f_kode_booking,
			f_kode_jamaah : info.f_kode_jamaah,
			f_kode_bayar : info.f_kode_bayar,
			f_nama_biaya : info.f_nama_biaya,
			f_jml_biaya : info.f_jml_biaya,
			f_jml_bayar : info.f_jml_bayar,
			f_updated_on:dateFormat(Date(),'yyyy-mm-dd HH:MM:ss'),
			f_updated_by:req.session.user
		};
		db.collection('t_pembayaran').updateOne({'_id':{$eq : ObjectId(req.param('_id'))}},{$set:vData},function(err, result) {
			if(err)
			{
				res.send(JSON.stringify({ success : false, message: 'Error Edit' }));
			}
			else
			{
				res.send(JSON.stringify({ success : true, message: 'Success Edit' }));
			}
		});
	}	else	{	res.send(JSON.stringify({ success : false, message: 'Access denied' }));	}
};

exports.delete = function(req, res) {
	if(req.session.akses.del == 1)
	{
		db.collection('t_pembayaran').removeOne({'_id':{$eq : ObjectId(req.param('id'))}},function(err, result) {
			if(err)
			{
				res.send(JSON.stringify({ success : false, message: 'Error Delete' }));
			}
			else
			{
				res.send(JSON.stringify({ success : true, message: 'Success Delete' }));
			}
		});
	}	else	{	res.send(JSON.stringify({ success : false, message: 'Access denied' }));	}
};

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
                'f_remark': '$f_remark',
                'f_bank': '$f_bank',
                'f_nama_pendaftar': '$f_nama_pendaftar',
                'f_nama_jamaah': '$f_nama_jamaah',
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
            from: 't_booking_umroh',
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
            result: result,
        };
        res.render(__dirname + '/../views/vw_history.html', vars);
    });
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
            from: 't_booking_umroh',
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
        // console.log(result);
        var vars = {
            title: 'Slip Pembayaran',
            subtitle: 'Slip Pembayaran',
            module: 'md_pembayaran_jamaah',
            act: 'printslip',
						user:req.session.user,
						per: req.session,
            result: result,
        };
        res.render(__dirname + '/../views/vw_slip.html', vars);
    });
};
