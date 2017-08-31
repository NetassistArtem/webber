function hideService(id_part){

 if($('#service_'+id_part).hasClass('service-hidden')){
 $('#service_'+id_part).removeClass('service-hidden');
  $('.collapse-th-td').removeClass('service-hidden');

 }else{
 $('#service_'+id_part).addClass('service-hidden');
  $('.collapse-th-td').addClass('service-hidden');
 }
 }
