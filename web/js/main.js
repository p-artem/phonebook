$(function () {
    $('#modalContent').click(function () {
        $('#modal').modal('show').find('#modalContent').load($(this).attr('value'))
    });

    $('.field-book-phones').delegate('span.phoneFiled','click',function () {

        if($(this).hasClass('phoneDel')){
            $(this).closest('.phoneBlock').remove();
            if(!$('span.phoneAdd').length){
                $('.phoneBlock').eq(-1).find('span.phoneFiled').text('+').removeClass('phoneDel').addClass('phoneAdd');
            }

        }

        if($(this).hasClass('phoneAdd')){

            var block = $(this).closest('.phoneBlock');
            var index = $(block).index();
            var elem = $(block).clone();
            var inputmask_9b84a9c0 = {"clearIncomplete":true,"mask":"+38(099)-999-99-99"};
            $(elem).removeClass('field-another-id' + index).addClass('field-another-id' + (index+1));
            $(elem).find('input').val('').attr('id', 'another-id' + (index+1)).inputmask(inputmask_9b84a9c0);
            $(elem).remove('label');
            if(index == 9){
                $(elem).find('span.phoneFiled').text('–').removeClass('phoneAdd').addClass('phoneDel');
            }
            block.after(elem);
            $(this).text('–').removeClass('phoneAdd').addClass('phoneDel');

            // var elem = block.clone();
            // // var inputmask_9b84a9c0 = {"mask":"+38(999)-999-99-99"};
            // // $(elem).find('input').val('').inputmask(inputmask_9b84a9c0);
            // if($(this).closest('.phoneBlock').index() == 9){
            //     $(elem).find('span.phoneFiled').text('–').removeClass('phoneAdd').addClass('phoneDel');
            // }
            // $('.field-book-phones').append(elem);
            // $(this).text('–').removeClass('phoneAdd').addClass('phoneDel');
        }
    });
});