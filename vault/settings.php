<?php
session_start();
if (!isset($_SESSION['User_ID'])) {
    header("Location: /authentication");
    die();
}
require_once(__DIR__ . '/config/db.php');
$namequery = "SELECT `Username` FROM `Credentials` WHERE `User_ID`=" . $_SESSION['User_ID'];
$nameres = mysqli_query($con, $namequery);
$namerow = $nameres->fetch_row();
if (isset($_POST['logout']) && $_POST['logout'] == 1) {
    echo '<script>
            var confirmLogout = window.confirm("Are you sure you want to log out?");
            if (confirmLogout) {
                window.location.href = "/vault/logout";
            } else {
                window.history.back();
            }
          </script>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Settings</title>
    <link rel="icon" type="image/png" href="./dist/images/favicon.png" />

    <!-- Icon Fonts -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;1,400;1,700&family=Source+Sans+Pro:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet" />
    <style>
        main p {
            margin-bottom: 40px;
            text-align: center;
        }
        main a {
            text-decoration: underline;
            color: #1889e6;
        }
        main a:hover {
            text-decoration: none;
        }

        /**/
        /* main styles */
        /**/
        .pcss3t {
            margin: 0;
            padding: 0;
            border: 0;
            outline: none;
            font-size: 0;
            text-align: left;
        }
        .pcss3t > input {
            position: absolute;
            left: -9999px;
        }
        .pcss3t > label {
            position: relative;
            display: inline-block;
            margin: 0;
            padding: 0;
            border: 0;
            outline: none;
            cursor: pointer;
            transition: all 0.1s;
            -o-transition: all 0.1s;	
            -ms-transition: all 0.1s;	
            -moz-transition: all 0.1s;	
            -webkit-transition: all 0.1s;
        }
        
        .pcss3t > input:checked + label {
            cursor: default;
        }
        .pcss3t > ul {
            list-style: none;
            position: relative;
            display: block;
            overflow: hidden;
            margin: 0;
            padding: 0;
            border: 0;
            outline: none;
            font-size: 13px;
        }
        .pcss3t > ul > li {
            position: absolute;
            width: 100%;
            overflow: auto;
            padding: 30px 40px 40px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            opacity: 0;
            transition: all 0.5s;
            -o-transition: all 0.5s;	
            -ms-transition: all 0.5s;	
            -moz-transition: all 0.5s;	
            -webkit-transition: all 0.5s;
        }
        .pcss3t > .tab-content-first:checked ~ ul .tab-content-first,
        .pcss3t > .tab-content-2:checked ~ ul .tab-content-2,
        .pcss3t > .tab-content-3:checked ~ ul .tab-content-3,
        .pcss3t > .tab-content-4:checked ~ ul .tab-content-4,
        .pcss3t > .tab-content-5:checked ~ ul .tab-content-5,
        .pcss3t > .tab-content-6:checked ~ ul .tab-content-6,
        .pcss3t > .tab-content-7:checked ~ ul .tab-content-7,
        .pcss3t > .tab-content-8:checked ~ ul .tab-content-8,
        .pcss3t > .tab-content-9:checked ~ ul .tab-content-9,
        .pcss3t > .tab-content-last:checked ~ ul .tab-content-last {
            z-index: 1;
            top: 0;
            left: 0;
            opacity: 1;
        }



        .pcss3t > label {	
            padding: 0 20px;
            background: #e5e5e5;
            font-size: 13px;
            line-height: 49px;
        }
        .pcss3t > label:hover {
            background: #f2f2f2;
        }
        .pcss3t > input:checked + label {
            background: #fff;
        }
        .pcss3t > ul {
            background: #fff;
            text-align: left;
        }
        .pcss3t-steps > label:hover {
            background: #e5e5e5;	
        }


        .pcss3t-theme-1 > label {
            margin: 0 5px 5px 0;
            border-radius: 5px;
            background: #fff;
            box-shadow: 0 2px rgba(0,0,0,0.2);
            color: #808080;
            opacity: 0.8;
        }
        .pcss3t-theme-1 > label:hover {
            background: #fff;
            opacity: 1;
        }
        .pcss3t-theme-1 > input:checked + label {
            margin-bottom: 0;
            padding-bottom: 5px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            color: #2b82d9;
            opacity: 1;
        }
        .pcss3t-theme-1 > ul {
            border-radius: 5px;
            box-shadow: 0 3px rgba(0,0,0,0.2);
        }
        .pcss3t-theme-1 > .tab-content-first:checked ~ ul {
            border-top-left-radius: 0;
        }
        

        .pcss3t > ul,
        .pcss3t > ul > li {
            height: 450px;
        }

        li img {
            width: 5rem;
            height: 5rem;
            border-radius: 50%;
            overflow: hidden;
        }
        
        /* reset password */
        .reset_password {
            width: 300px;
            margin: 0 auto;
            text-align: center;
        }
        .reset_password form {
            background-color: #f3f3f3;
            padding: 20px;
            border-radius: 5px;
        }
        .reset_password label {
            display: block;
            margin-bottom: 10px;
        }
        .reset_password input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .reset_password button, .reset {
            background-color: #0074d9;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .reset_password button:hover {
            background-color: #0056b3;
        }

        /* Style the form container */
        .contact-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        /* Style the form heading */
        .contact-heading {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Style the form labels */
        .contact-label {
            display: block;
            margin: 10px 0;
            font-weight: bold;
        }

        /* Style the form input fields */
        .contact-input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        /* Style the form textarea */
        .contact-textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        /* Style the form submit button */
        .contact-submit {
            background-color: #0074d9;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .contact-submit:hover {
            background-color: #0056b3;
        }


        /* Style the form container */
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        /* Style the form heading */
        .form-heading {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Style the form labels */
        .form-label {
            display: block;
            margin: 10px 0;
            font-weight: bold;
        }

        /* Style the form input fields */
        .form-input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        /* Style the form select input (Country) */
        .form-select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        /* Style the form submit button */
        .form-submit {
            background-color: #0074d9;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .form-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar Section -->
        <aside>
            <div class="toggle">
                <div class="logo">
                    <!-- <img src="images/profile.jpg"> -->
                    <h2>Password<br><span class="danger">Manager</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">
                        close
                    </span>
                </div>
            </div>

            <div class="sidebar">
                <a href="/vault">
                    <span class="material-icons-sharp">
                        dashboard
                    </span>
                    <h3>Dashboard</h3>
                </a>
                <!-- <a href="#">
                    <span class="material-icons-sharp">
                        person_outline
                    </span>
                    <h3>User</h3>
                </a> -->
                <a href="#" class="active">
                    <span class="material-icons-sharp">
                        settings
                    </span>
                    <h3>Settings</h3>
                </a>
                <a href="/vault/add-password">
                    <span class="material-icons-sharp">
                        add
                    </span>
                    <h3>Add Password</h3>
                </a>
                <a href="/vault/uploads">
                    <span class="material-icons-sharp">
                        upload
                    </span>
                    <h3>Upload</h3>
                </a>
                <form method="post">
                    <input type="hidden" name="logout" value="1">
                    <button type="submit">
                        <span class="material-icons-sharp">
                            logout
                        </span>
                        <h3>Logout</h3>
                    </button>
                </form>
            </div>
        </aside>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
        <h1>Settings</h1><br>
            <!-- tabs -->
			<div class="pcss3t pcss3t-effect-scale pcss3t-theme-1">
				<input type="radio" name="pcss3t" checked  id="tab1"class="tab-content-first">
				<label for="tab1"><span class="material-icons-sharp">
                    person
                </span>User-Profile</label>
				
				<input type="radio" name="pcss3t" id="tab2" class="tab-content-2">
				<label for="tab2"><span class="material-icons-sharp">
                    visibility
                </span>Change Password</label>
				
				<input type="radio" name="pcss3t" id="tab3" class="tab-content-3">
				<label for="tab3"><span class="material-icons-sharp">
                    contact_support
                </span>Contact</label>
				
				<input type="radio" name="pcss3t" id="tab4" class="tab-content-last">
				<label for="tab4"><span class="material-icons-sharp">
                    info
                </span>About</label>
				
				<ul>
					<li class="tab-content tab-content-first typography">
						
                        <div class="form-container">
                            <h2 class="form-heading">User Information</h2>
                            <div class="profile-photo">
                                <img src="images/profile-1.jpg">
                            </div>
                            <form action="#" method="post">
                              <label for="username" class="form-label">Username:</label>
                              <input type="text" id="username" name="username" class="form-input">
                              
                              <label for="phone" class="form-label">Phone Number:</label>
                              <input type="tel" id="phone" name="phone" class="form-input">
                              
                              <label for="email" class="form-label">Email:</label>
                              <input type="email" id="email" name="email" class="form-input">
                              
                              <label for="address" class="form-label">Address:</label>
                              <input type="text" id="address" name="address" class="form-input">
                              
                              <label for="country" class="form-label">Country:</label>
                              <select id="country" name="country" class="form-select">
                                <option value="usa">India</option>
                                <option value="canada">USA</option>
                                <option value="other">Other</option>
                              </select>
                              
                              <button type="submit" class="form-submit">Submit</button>
                            </form>
                        </div>
					</li>
					
					<li class="tab-content tab-content-2 typography">
						<h4>Reset Master-Password</h4>
                        <div class="reset_password">
                            <form action="#" method="post">
                                <label for="newPassword">Enter new Password</label>
                                <input type="password" id="newPassword" name="newPassword">
                                <br>
                                <label for="confirmPassword">Confirm new Password</label>
                                <input type="password" id="confirmPassword" name="confirmPassword">
                                <br>
                                <input class="reset" type="reset" value="Reset Changes">
                                <button type="submit">Submit</button>
                            </form>
                        </div>
                        
                        
					</li>
					
					<li class="tab-content tab-content-3 typography">
						<div class="contact-container">
                            <h2 class="contact-heading">Contact Us</h2>
                            <form action="#" method="post">
                              <label for="name" class="contact-label">Name:</label>
                              <input type="text" id="name" name="name" class="contact-input">
                              
                              <label for="email" class="contact-label">Email:</label>
                              <input type="email" id="email" name="email" class="contact-input">
                              
                              <label for="message" class="contact-label">Message:</label>
                              <textarea id="message" name="message" rows="4" class="contact-textarea"></textarea>
                              
                              <button type="submit" class="contact-submit">Submit</button>
                            </form>
                          </div>
					</li>
					
					<li class="tab-content tab-content-last typography">
						Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquid dolor repellendus, nulla ducimus odit atque quam architecto deleniti iusto officiis libero, adipisci, illo minus? Magni ad fuga ea placeat delectus.
					</li>
				</ul>
			</div>
        </main>
        <!-- End of Main Content -->

        <!-- Right Section -->
        <div class="right-section">
            <div class="nav">
                <button id="menu-btn">
                    <span class="material-icons-sharp">
                        menu
                    </span>
                </button>
                <div class="dark-mode">
                    <span class="material-icons-sharp active">
                        light_mode
                    </span>
                    <span class="material-icons-sharp">
                        dark_mode
                    </span>
                </div>

                <div class="profile">
                    <div class="info">
                        <p>Hey, <b><?php echo $namerow[0] ?></b></p>
                    </div>
                    <div class="profile-photo">
                        <img src="<?php echo '/vault/Icons/' . $_SESSION['User_ID'] . '_user_icon.png' ?>">
                    </div>
                </div>

            </div>
            <!-- End of Nav -->
        </div>
    </div>


    <script src="index.js"></script>
</body>

</html>