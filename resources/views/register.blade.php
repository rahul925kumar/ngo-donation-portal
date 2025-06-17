<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="form1.css">
    <title>Document</title>
    <style>
        * {
    box-sizing: border-box;
    margin: 0px;
}

form {
    border: 2px solid rgba(255, 255, 255, 0);
    border-radius: 10px;
    width: 60rem;
    margin: auto;
    height: 40rem;
    margin-top: 4rem;
    position: absolute;
    top: -4%;
    left: 23%;
    background-color: rgba(255, 255, 255, 0.9);
}

table {
    /* border:2px solid black; */
    height: 35rem;
    width: 50rem;
    margin: auto;
    border-spacing: 0.50rem;
}



form>h1 {
    text-align: center;
    margin-bottom: 1rem;
    color: #483893;
    font-size: 3rem;
    margin-top: 1rem;
}

select {
    height: 80%;
    width: 100%;
    box-shadow: inset 0 1px 2px rgb(0 0 0 / 8%);
    background-clip: padding-box;
    background-color: #f8f9fa;
    border: 1px solid #f8f9fa;
    border-radius:3px;
    font-size:0.85rem;
}

/* td{
  height:3rem;
} */
input[type="text"],
input[type="date"],
input[type="tel"],
input[type="email"] {
    height: 80%;
    width: 100%;
    box-shadow: inset 0 1px 2px rgb(0 0 0 / 8%);
    background-clip: padding-box;
    background-color: #f8f9fa;
    border: 1px solid #f8f9fa;
    border-radius:3px;
    font-size:0.85rem;
}

input[type="submit"],
input[type="reset"] {
    height: 80%;
    width: 100%;
}

input[type="submit"] {
    background: linear-gradient(90deg, #ff7400 28.12%, #f91717);
    border-radius: 100px;
    color: #fff;

    font-weight: 500;
    transition: all 0.3s ease-in-out;
    font-size: 14px;
    text-transform: uppercase;
    border:none;

}

input[type="reset"] {
    border-radius: 10px;
    color: grey;
    font-weight: 500;
    font-size: 14px;
    text-transform: uppercase;
}

#link {
    margin-left: 16rem;
}

input[placeholder] {
    text-align: start;
    vertical-align: 0px;
    font-size:0.85rem;
}


div#videoo {
    position: relative;
    width: 99vw;
    height: 100vh;
   
}

#videoo>video {
    width: 100%;

}

select > option > span{
    color:grey;

}
    </style>
</head>

<body>
    <div id="videoo">
        <video class="elementor-video" src="https://gausevasociety.com/wp-content/uploads/2024/11/gaushala.mp4"
            autoplay="" loop="" muted="muted" playsinline="" ></video>
  
    <form action="#">
        <h1>Donor Registration</h1>
        <table>
            <tr>
                <td>
                    <label></label>
                    <select name="Salutation" id="salutation">
                        <option value="" disabled selected><span style="color:lightgrey">Salutation:</span> Please Select</option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                </td>
                <td>
                    <input type="text" placeholder="First Name">
                </td>
                <td>
                    <input type="text" placeholder="Last Name">
                </td>
                <td>
                    <input type="date" placeholder="Date of Birth">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="tel" placeholder="Mobile Number">
                </td>

                <td colspan="2">

                    <input type="email" placeholder="Email">
                </td>

            </tr>
            <tr>
                <td>
                    <select name="country">
                        <option value="" disabled selected>Select country</option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                </td>
                <td>
                    <select name="state">
                        <option value="" disabled selected><span>State</span></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                </td>
                <td>
                    <select name="district">
                        <option value="" disabled selected><span>District</span></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                </td>
                <td>
                    <select name="city">
                        <option value="" disabled selected><span>City</span></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="text" placeholder="Pincode">
                </td>
                <td colspan="2">
                    <select name="source">
                        <option value="" disabled selected>Source: Please Select</option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="4">

                    <input type="checkbox" id="chk">
                    <label for="chk">Enter Complete Address for Postal Communication</label>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="Register">
                </td>
                <td colspan="2">
                    <input type="reset" value="Reset">
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <a href="#" id="link">Already Registered? Click here for login</a>
                </td>
            </tr>
        </table>
    </form>
    </div>
</body>

</html>