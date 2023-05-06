$(document).ready(function() {
    $('.btn-plus').click(function() {
        $parentNode = $(this).parents("tr");
        $qty = Number($parentNode.find('#qty').val());

        $price = $parentNode.find('#price').text();
        $price = $price.replace("MMK", "");

        $total = $price * $qty;

        $parentNode.find('.total').html($total + " MMK");
        grandTotal();
    })

    $('.btn-minus').click(function() {
        $parentNode = $(this).parents("tr");
        $qty = Number($parentNode.find('#qty').val());

        if ($qty >= 0) {
            $price = $parentNode.find('#price').text();
            $price = $price.replace("MMK", "");

            $total = $price * $qty;

            $parentNode.find('.total').html($total + " MMK");
           grandTotal();
        }

    })
    // For GRAND TOTAL
    function grandTotal(){
        $total = 0;
        $('#dataTable tbody tr').each(function(index, row) {
            $total += Number($(row).find('.total').text().replace('MMK', ''));
        });

        $('#subTotal').html(`${$total} MMK`);
        $('#grandTotal').html(`${$total+1000} MMK`);
    }

    $('.btnRemove').click(function() {
        $parentNode = $(this).parents("tr");
        console.log($parentNode);
        $parentNode.remove();
    })
})
