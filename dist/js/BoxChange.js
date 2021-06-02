$("#staff_list").change(function() {
  if ($(this).val() == "Notonlist") {
    $('#div_name').show();
    $('#user_name').attr('required', '');
    $('#user_name').attr('data-error', 'This field is required.');
      $('#div_secondname').show();
      $('#div_surname').show();
    $('#user_surnamename').attr('required', '');
    $('#user_surnamename').attr('data-error', 'This field is required.');
      
      $('#div_email').show();
    $('#user_email').attr('required', '');
    $('#user_email').attr('data-error', 'This field is required.');
      
      $('#div_title').show();
    $('#Title').attr('required', '');
    $('#Title').attr('data-error', 'This field is required.');
  } else {
    $('#div_name').hide();
    $('#user_name').removeAttr('required');
    $('#user_name').removeAttr('data-error');
      
      $('#div_secondname').hide();
    $('#user_sname').removeAttr('required');
    $('#user_sname').removeAttr('data-error');
      
      $('#div_surname').hide();
    $('#user_surnamename').removeAttr('required');
    $('#user_surnamename').removeAttr('data-error');
      
      $('#div_email').hide();
    $('#user_email').removeAttr('required');
    $('#user_email').removeAttr('data-error');
      
      $('#div_title').hide();
    $('#Title').removeAttr('required');
    $('#Title').removeAttr('data-error');
  }
});
$("#staff_list").trigger("change");

$('#Title').change(function()
{
    if ($(this).val() == 'Notonlist')
    $('#Title').replaceWith('<input class="form-control" type="text" placeholder="Job title" id="Title" name="Title">');
});

$("#Model").change(function() {
  if ($(this).val() == "Notonlist") {
         $('#div_model').show();
        $('#no_model').attr('required', '');
        $('#no_model').attr('data-error', 'This field is required.');
    }else{
        $('#div_model').hide();
        $('#no_model').removeAttr('required');
        $('#no_model').removeAttr('data-error');
    }
});
$("#Model").trigger("change");

$("#Type").change(function() {
  if ($(this).val() == "Notonlist") {
         $('#div_type').show();
        $('#no_type').attr('required', '');
        $('#no_type').attr('data-error', 'This field is required.');
    }else{
        $('#div_type').hide();
        $('#no_type').removeAttr('required');
        $('#no_type').removeAttr('data-error');
    }
});
$("#Type").trigger("change");

$("#device_type").change(function() {
  if ($(this).val() == "Notonlist") {
         $('#form_type').show();
      $('#form_brand').show();
      $('#form_model').show();
    }else{
        $('#form_type').hide();
        $('#form_brand').hide();
        $('#form_model').hide();
        
    }
});
$("#device_type").trigger("change");

$("#Brand").change(function() {
if ($(this).val() == "Notonlist") {
         $('#div_brand').show();
        $('#no_brand').attr('required', '');
        $('#no_brand').attr('data-error', 'This field is required.');
    }else{
        $('#div_brand').hide();
        $('#no_brand').removeAttr('required');
        $('#no_brand').removeAttr('data-error');
    }
});
$("#Brand").trigger("change");

$("#specs").change(function() {
if ($(this).val() == "Notonlist") {
         $('#div_specs').show();
        $('#no_specs').attr('required', '');
        $('#no_specs').attr('data-error', 'This field is required.');
    }else{
        $('#div_specs').hide();
        $('#no_specs').removeAttr('required');
        $('#no_specs').removeAttr('data-error');
    }
});
$("#specs").trigger("change");

$("#Reason").change(function() {
if ($(this).val() == "Notonlist") {
         $('#div_reason').show();
        $('#no_reason').attr('required', '');
        $('#no_reason').attr('data-error', 'This field is required.');
    }else{
        $('#div_reason').hide();
        $('#no_reason').removeAttr('required');
        $('#no_reason').removeAttr('data-error');
    }
});
$("#Reason").trigger("change");

$("#Department").change(function() {
if ($(this).val() == "Notonlist") {
         $('#div_department').show();
        $('#no_department').attr('required', '');
        $('#no_department').attr('data-error', 'This field is required.');
    }else{
        $('#div_department').hide();
        $('#no_department').removeAttr('required');
        $('#no_department').removeAttr('data-error');
    }
});
$("#Department").trigger("change");

$("#Item").change(function() {
if ($(this).val() == "Notonlist") {
         $('#div_item').show();
        $('#no_item').attr('required', '');
        $('#no_item').attr('data-error', 'This field is required.');
    }else{
        $('#div_item').hide();
        $('#no_item').removeAttr('required');
        $('#no_item').removeAttr('data-error');
    }
});
$("#Item").trigger("change");

$("#Faculty").change(function() {
if ($(this).val() == "Notonlist") {
         $('#div_faculty').show();
        $('#no_faculty').attr('required', '');
        $('#no_faculty').attr('data-error', 'This field is required.');
    }else{
        $('#div_faculty').hide();
        $('#no_faculty').removeAttr('required');
        $('#no_faculty').removeAttr('data-error');
    }
});
$("#Faculty").trigger("change");

$("#usertype").change(function() {
if ($(this).val() == "Notonlist") {
         $('#div_utype').show();
        $('no_utype').attr('required', '');
        $('#no_utype').attr('data-error', 'This field is required.');
    }else{
        $('#div_utype').hide();
        $('#no_utype').removeAttr('required');
        $('#no_utype').removeAttr('data-error');
    }
});
$("#usertype").trigger("change");

$("#Area").change(function() {
if ($(this).val() == "Notonlist") {
         $('#div_area').show();
        $('#no_area').attr('required', '');
        $('#no_area').attr('data-error', 'This field is required.');
    }else{
        $('#div_area').hide();
        $('#no_area').removeAttr('required');
        $('#no_area').removeAttr('data-error');
    }
});
$("#Area").trigger("change");

$("#Location").change(function() {
if ($(this).val() == "Notonlist") {
         $('#div_location').show();
        $('#no_location').attr('required', '');
        $('#no_location').attr('data-error', 'This field is required.');
    }else{
        $('#div_location').hide();
        $('#no_location').removeAttr('required');
        $('#no_location').removeAttr('data-error');
    }
});
$("#Location").trigger("change");

$("#Brand").change(function() {
if ($(this).val() == "Notonlist") {
         $('#div_brand').show();
        $('#no_brand').attr('required', '');
        $('#no_brand').attr('data-error', 'This field is required.');
    }else{
        $('#div_brand').hide();
        $('#no_brand').removeAttr('required');
        $('#no_brand').removeAttr('data-error');
    }
});
$("#Brand").trigger("change");