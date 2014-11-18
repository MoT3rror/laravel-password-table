<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
	<style>
		@import url(//fonts.googleapis.com/css?family=Lato:700);

        html, body, .column-left, .column-right {
            height: 100%;
        }
        body {
            margin:0;
            font-family:'Lato', sans-serif;
            color: #999;
            margin-top: auto;
            margin-bottom: auto;
		}
        a, a:visited {
            color: #999;
            text-decoration: none;
        }
        .column-left {
            float: left;
            width: 60%;
            margin-left: 5%;
        }
        .column-right {
            float: right;
            width: 30%;
            margin-right: 5%;
            text-align: right;
        }
        .user-list {
            overflow: auto;
            height: 40%;
        }
        .user-list ul {
            list-style: none;
        }
        #register {
            margin-top: 10%;
            display: block;
        }
        #register_box fieldset {
            width: 50%;
            margin-top: 5%;
            float: right;
        }
        #register_box input {
            width: 100%;
        }
        #pie-chart {
            width: 100%;
            text-align: center
        }
        #pie-chart canvas {
            width: 50%;
        }
	</style>
</head>
<body>
	<div class="column-left">
        <h1>Users still need to be cracked</h1>
        <div class="user-list" id="usersNotCracked">
            <ul></ul>
        </div>
        <h1>Users that have got their password stolen</h1>
        <div class="user-list" id="usersCracked">
            <ul></ul>
        </div>
    </div>
    <div class="column-right">
        <div style="height: 45%; width: 100%">
            <a href="#" id="register">Register a user</a>
            <div id="register_box">
                <form action="#" id="register_form">
                    <fieldset>
                        <dl>Username</dl>
                        <dt><input type="text" name="username" /></dt>

                        <dl>Password</dl>
                        <dt><input type="password" name="password" /></dt>

                        <dt><input type="submit" value="Register" /></dt>
                    </fieldset>
                </form>
            </div>

            <div id="register_success">
                Thanks for registering! Check left to see how long it takes.
            </div>

            <div id="register_error">
                You messed up!
            </div>
        </div>

        <h1 style="width: 100%; clear: both">Users password cracked percent</h1>
        <div id="pie-chart" data-percent="0"></div>
    </div>
    <script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/easy-pie-chart/2.1.4/jquery.easypiechart.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#register_box').hide();
        $('#register_success').hide();
        $('#register_error').hide();

        $('#register').on('click', function() {
            $('#register_box').show();
        });

        $('#register_form').on('submit', function(e) {
            e.preventDefault();

            $('register_error').hide();
            $.post('{{ route('doRegister') }}', $('#register_form').serializeArray(), function (data) {
                if (data.success) {
                    $('#register_box').hide();
                    $('#register_success').show();

                } else {
                    $('#register_error').show();
                }
            }, 'json');
        });

        $('#pie-chart').easyPieChart({});

        var getUserInfo = function() {
            $.getJSON('{{ route('getInfo') }}', function (data) {
                $('#pie-chart').data('easyPieChart').update(data.percentage);

                var ul = $('#usersCracked ul');
                ul.empty();
                $.each(data.users_cracked, function(index, value) {
                    ul.append('<li>' + value.username + '</li>');
                });

                var ul = $('#usersNotCracked ul');
                ul.empty();
                $.each(data.users_needed, function(index, value) {
                    ul.append('<li>' + value.username + '</li>');
                });
            });
            setTimeout(getUserInfo, 5000);
        };

        getUserInfo();
    });
    </script>
</body>
</html>
