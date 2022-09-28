$(document).ready(function()
{
    $.ajax({
        type: "GET",
        url: "https://jsonplaceholder.typicode.com/users",
        success: function(data) {
            let table = "";
            $(data).each(function(){
                let user = $(this)[0];
                table += "<tr>"+
                    "<td>"+ user.name +"</td>"+
                    "<td>"+ user.username +"</td>"+
                    "<td>"+ user.phone +"</td>"+
                    "<td>"+ user.company.name +"</td>"+
                "</tr>";
            });
            $("#home-table tbody").html(table);
        }
    });
});