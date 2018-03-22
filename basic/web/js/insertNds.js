
function insertNds(className, targetId) {
   var value;
    var valueNds;
   value = $('input.'+className).val();
   valueNds = (value*1.20).toFixed(2);
    $('#'+targetId).text(valueNds);
}
