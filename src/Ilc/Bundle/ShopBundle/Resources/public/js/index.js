$(document).ready(function(){
	$('.add_cart').click(function(event){
		event.preventDefault();
		var id = $(this).data('id');
		
		$.post(urlAddCart, {'id': id}, function(res){
			console.log(res);
			refreshCartItem();
			$('#notif').slideDown('fast').delay(1500).slideUp('fast');
		});
	});

	$('.delete_cart').click(function(event){
		event.preventDefault();
		var id = $(this).data('id');
		var url = $(this).attr('href');
		var line = $(this).parent().parent();

		$.post(url, {'id': id}, function(res){
			console.log(res);
			line.remove();
			refreshCartItem();
		})
	});

	$('.cart_quantity').change(function(){
		var line = $(this).parent().parent();
		var url = $(this).data('url');
		var id = $(this).data('id');
		var val = $(this).val();

		if(val <= 0){
			$(this).val(1);
			val = 1;
		}

		$.post(url, {'id': id, 'qty': $(this).val()}, function(res){
			console.log(res);
			var data = JSON.parse(res);
			line.find('.total').html(data.total);
			refreshCartItem();
		});
	});

	$('.sort_select').change(function(){
		var url = $(this).val();

		window.location = url;
	});
        
        
    $('.use_prev').click(function(){
        if($(this).is(':Checked')) {
            $(this).parent().parent().attr('novalidate', 'novalidate');
        }
        else {
            $(this).parent().parent().removeAttr('novalidate');
        }
    });

    $('.hide_option').click(function(event){
    	event.preventDefault();

    	$(this).parent().parent().find('.filter_bottom').slideToggle();
    })

	function refreshCartItem() {
		var _countCartItem = $('.countCartItem');

		$.get(urlCountCartItem, {},function(res){
			console.log(res);
			var data = JSON.parse(res);
			_countCartItem.html(data.quantity);
		});
	}
});