<form action = "TicketFilterBars/filterTicket.php" method='post'>
    <ul style = "list-style-type: none;margin: 0;padding: 0;overflow: hidden;background-color: #333;align-text:center">
        <li class = "active-filter" style="float:left;display: block;color: white;text-align: center;padding: 31px 10px;text-decoration: none;align:left"><text>Filter</text></li>
        <li style="float:left;display: block;color: white;text-align: center;padding: 24px 10px;text-decoration: none"><input placeholder = "ID" type = "text" id = "ticket-search-id" name = "ticketsearchid"></li>
        <li style="float:left;display: block;color: white;text-align: center;padding: 24px 10px;text-decoration: none"><input placeholder = "Apartment" type = "text" id = "ticket-search-apartment" name = "ticketsearchapartment"></li>
        <li style="float:left;display: block;color: white;text-align: center;padding: 24px 10px;text-decoration: none"><input placeholder = "Title" type = "text" id = "ticket-search-title" name = "ticketsearchtitle"></li>
        <li style="float:left;display: block;color: white;text-align: center;padding: 20px 10px;text-decoration: none">
        <div class='dropdown text-centered'>
            <select class='btn btn-secondary dropdown-toggle' type='button' id='signup-gender' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' name='ticketsearchStatus'>
                <option class='dropdown-item' value="">Status </option>
                <option class='dropdown-item' value="CREATED">Created</option>
                <option class='dropdown-item' value = "OPEN">Open</option>
                <option class='dropdown-item' value = "CLOSED">Closed</option>
                <option class='dropdown-item' value = "CANCELED">Canceled</option>
            </select>
        </div>
        </li>
        <li style="float:left;display: block;color: white;text-align: center;padding: 20px 16px;text-decoration: none">
        <div class='dropdown text-centered'>
            <select class='btn btn-secondary dropdown-toggle' type='button' id='signup-gender' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' name='ticketsearchArea'>
                <option class='dropdown-item' value="">Area</option>
                <option class='dropdown-item' value="sky-east">Sky East</option>
                <option class='dropdown-item' value = "sky-west">Sky West</option>
                <option class='dropdown-item' value = "sky-north">Sky North</option>
            </select>
        </div>
        </li>
        <li style="float:right;display: block;color: white;text-align: center;padding: 24px 16px;text-decoration: none"><input class = 'btn' style = 'color:white;background-color:crimson;' value = "Search" type = "submit"></li>
    </ul>
</form>
