var start = 2005;
var end = new Date().getFullYear();
var options = "";
for(var year = start ; year <=end; year++){
    $yearafter = year + 1;
    options += "<option>"+ year + "/" + $yearafter +"</option>";
}
document.getElementById("tahun-ajaran-edit").innerHTML = options;