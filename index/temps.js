$.ajax({
    url: "../serve/get_user_data.php",
    type: 'GET',
    success: function (data) {
        data = JSON.parse(data)
        if(data && data.code == 0){
            
        }
        else{
            
        }
    },
});