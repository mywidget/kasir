function formatMoney(number, places, symbol, thousand, decimal) {
    number = number || 0;
    places = !isNaN(places = Math.abs(places)) ? places : 0;
    symbol = symbol !== undefined ? symbol : "";
    thousand = thousand || ".";
    decimal = decimal || ",";
    var negative = number < 0 ? "-" : "",
	i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
	j = (j = i.length) > 3 ? j % 3 : 0;
    return symbol + negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
}

function formatNumber(myElement) { // JavaScript function to insert thousand separators
    var myVal = ""; // The number part
	
    var parts = myElement.value.toString().split("|");
	
    parts[0] = parts[0].replace(/[^0-9]/g, "");
    // Adding the thousand separator
    while (parts[0].length > 3) {
        myVal = "." + parts[0].substr(parts[0].length - 3, parts[0].length) + myVal;
        parts[0] = parts[0].substr(0, parts[0].length - 3)
	}
    myElement.value = parts[0] + myVal;
	
}

function angka(number) {
	var number = number?number:"";
    var re = number.replace("Rp.", "");
    var res = replaceAll(".", "", re);
    return res;
}

function replaceAll(find, replace, str) {
    while (str.indexOf(find) > -1) {
        str = str.replace(find, replace);
	}
    return str;
}


function doMath() {
    var i = $("#tablein > tbody").children().length;
    // alert(i);
    var njml = [];
    var nharga = [];
    var ndiskon = [];
    var totharga = [];
    var totdiskon = [];
    var hargasdiskon = [];
    var nUangMuka = 0;
    var nUangMuka2 = 0;
    var pajaksum = 0;
    var sisa = 0;
    var totsemua = 0;
    var tot_uangmuka = 0;
    var tpajak;
	
    nUangMuka = angka(document.getElementById("uangmuka").value);
    pajaksum = document.getElementById("pajaksum").value;
	// alert(nUangMuka2);
    for (var a = 0; a < i; a++) {
		
        if ($("#jumlah_" + a).length == 0) { continue; }
        njml[a] = document.getElementById("jumlah_" + a.toString()).value;
        nharga[a] = document.getElementById("harga_" + a.toString()).value;
        ndiskon[a] = document.getElementById("diskon_" + a.toString()).value;
        totdiskon[a] = angka(nharga[a]) * ndiskon[a] / 100;
        hargasdiskon[a] = (angka(nharga[a])) - (totdiskon[a]);
        totharga[a] = angka(njml[a]) * hargasdiskon[a];
        document.getElementById("total_" + a.toString()).value = formatMoney(totharga[a], 0, "Rp.");
        totsemua += totharga[a];
	}
    tot_uangmuka = parseInt(nUangMuka2) + parseInt(angka(nUangMuka));
	
	tpajak = totsemua + ((totsemua * pajaksum) /100);
    sisa = ((totsemua * pajaksum) /100) + totsemua - angka(nUangMuka);
	// alert(pajaksum);
    //cek total bayar
    // cek_total(tot_uangmuka, totsemua);
	
    document.getElementById("uangmuka").value = formatMoney(angka(nUangMuka), 0, "Rp.");
    document.getElementById("totalSum").value = formatMoney(tpajak, 0, "Rp.");
    document.getElementById("sisaSum").value = formatMoney(sisa, 0, "Rp.");
    document.getElementById("pajak").value = pajaksum;
    document.getElementById("sisabayar").value = formatMoney(sisa, 0, "Rp.");
	
	
}
function doPengeluaran() {
    var i = $("#table_pengeluaran > tbody").children().length;
    // alert(i);
    var njml = [];
    var nharga = [];
    var totharga = [];
    var sisa = 0;
    var totsemua = 0;
  
    // nUangMuka = angka(document.getElementById("uangmuka").value);
    // pajaksum = document.getElementById("pajaksum").value;
	// alert(nUangMuka2);
    for (var a = 0; a < i; a++) {
		
        if ($("#jum_" + a).length == 0) { continue; }
        njml[a] = document.getElementById("jum_" + a.toString()).value;
        nharga[a] = document.getElementById("pharga_" + a.toString()).value;
        totharga[a] = angka(njml[a]) * angka(nharga[a]);
        document.getElementById("ptotal_" + a.toString()).value = formatMoney(totharga[a], 0, "Rp.");
        totsemua += totharga[a];
	}
    // tot_uangmuka = parseInt(nUangMuka2) + parseInt(angka(nUangMuka));
	
    document.getElementById("total_pengeluaran").value = formatMoney(totsemua, 0, "Rp.");
	
	
}