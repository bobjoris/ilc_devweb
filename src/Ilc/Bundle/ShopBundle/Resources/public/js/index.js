$(document).ready(function(){
	$('.add_cart').click(function(event){
		event.preventDefault();
		var id = $(this).data('id');
		
		$.post(urlAddCart, {'id': id}, function(res){
			console.log(res);
			refreshCartItem();
		});
	});

	function refreshCartItem() {
		var _countCartItem = $('.countCartItem');

		$.get(urlCountCartItem, {},function(res){
			console.log(res);
			var data = JSON.parse(res);
			_countCartItem.html(data.quantity);
		});
	}
});