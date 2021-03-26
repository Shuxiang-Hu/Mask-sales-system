//compute the total cost of masks
function computeCost(){
    //get mask types
    var mask1 = document.getElementById("N95 respirator");
    var mask2 = document.getElementById("surgical mask");
    var mask3 = document.getElementById("N95 surgical respirator");
    var price = 0;
    //find the checked mask type and get its price
    if(mask1.checked === true)
    {
        price = mask1.value;
    }
    else if(mask2.checked === true)
    {
        price = mask2.value;
    }
    else if(mask3.checked === true)
    {
        price = mask3.value;
    }

    var quantity = document.getElementById("quantity").value;

    document.getElementById("total").value = (1.0 * price) * (1.0 * quantity); 




}