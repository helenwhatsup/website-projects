import React from "react";
import ReactDOM from "react-dom";
import axios from 'axios'

function APP(){
return(

<div class = 'container'>
    <h1>Book Search</h1>
<form>
<div class="form-group">
<input type="text" className="input-control" placeholder="search" autoComplete="off">
</input>
</div>
<button type="submit" className="search">Search for books</button>
</form>
</div>
)



}