<!DOCTYPE html>
<html>
<head>
    <title>Chat - kalffman</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.10.1/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.10.1/firebase-auth.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    <script>
        const fbaseConfig = {
            apiKey: "AIzaSyCG_ZQhVQmphQLsmsSlp3KTueqv2B4Z-b4",
            authDomain: "chat-kalffman.firebaseapp.com",
            databaseURL: "https://chat-kalffman.firebaseio.com",
            projectId: "chat-kalffman",
            storageBucket: "chat-kalffman.appspot.com",
            messagingSenderId: "295585241253"
        };
        let fbaseDatabase;
        let fbaseAuth;
        let fbaseAuthUser;
        let divContent;
    </script>
    <style type="text/css">
        .sa {
            height: 100%;
            padding: 26px;
            background-color: #fff;
        }

        .sa-success {
            border-radius: 50%;
            border: 4px solid #a5dc86;
            box-sizing: content-box;
            height: 80px;
            padding: 0;
            position: relative;
            background-color: #fff;
            width: 80px;
            left: calc(50% - 40px);
        }

        .sa-success:after, .sa-success:before {
            background: #fff;
            content: "";
            height: 120px;
            position: absolute;
            transform: rotate(45deg);
            width: 60px;
        }

        .sa-success:before {
            border-radius: 40px 0 0 40px;
            width: 26px;
            height: 80px;
            top: -17px;
            left: 5px;
            transform-origin: 60px 60px;
            transform: rotate(-45deg);
        }

        .sa-success:after {
            border-radius: 0 120px 120px 0;
            left: 30px;
            top: -11px;
            transform-origin: 0 60px;
            transform: rotate(-45deg);
            animation: rotatePlaceholder 4.25s ease-in;
        }

        .sa-success-placeholder {
            border-radius: 50%;
            border: 4px solid rgba(165, 220, 134, 0.25);
            box-sizing: content-box;
            height: 80px;
            left: -4px;
            position: absolute;
            top: -4px;
            width: 80px;
            z-index: 2;
        }

        .sa-success-fix {
            background-color: #fff;
            height: 90px;
            left: 28px;
            position: absolute;
            top: 8px;
            transform: rotate(-45deg);
            width: 5px;
            z-index: 1;
        }

        .sa-success-tip, .sa-success-long {
            background-color: #a5dc86;
            border-radius: 2px;
            height: 5px;
            position: absolute;
            z-index: 2;
        }

        .sa-success-tip {
            left: 14px;
            top: 46px;
            transform: rotate(45deg);
            width: 25px;
            animation: animateSuccessTip 0.75s;
        }

        .sa-success-long {
            right: 8px;
            top: 38px;
            transform: rotate(-45deg);
            width: 47px;
            animation: animateSuccessLong 0.75s;
        }

        @keyframes animateSuccessTip {
            0%,
            54% {
                width: 0;
                left: 1px;
                top: 19px;
            }
            70% {
                width: 50px;
                left: -8px;
                top: 37px;
            }
            84% {
                width: 17px;
                left: 21px;
                top: 48px;
            }
            100% {
                width: 25px;
                left: 14px;
                top: 45px;
            }
        }

        @keyframes animateSuccessLong {
            0%,
            65% {
                width: 0;
                right: 46px;
                top: 54px;
            }
            84% {
                width: 55px;
                right: 0;
                top: 35px;
            }
            100% {
                width: 47px;
                right: 8px;
                top: 38px;
            }
        }

        @keyframes rotatePlaceholder {
            0%,
            5% {
                transform: rotate(-45deg);
            }
            100%,
            12% {
                transform: rotate(-405deg);
            }
        }
    </style>
     <style type="text/css">

        *{
            font-family: Titillium Web, sans-serif;
        }

        .chat-box{
            display: block;
            margin: 0 auto;
            width:100%;
            border-radius: 7px;
            border: 2px solid #1e90ff9e;
        }

        .chat-header{
            background-color: #c8c8c8;
            height: 40px;
            padding: 5px;
            border-radius: 5px 5px 0 0;
        }

        .chat-body{
            color: #111111;
            background-color: #f0f0f0;
            height: 380px;
            overflow-y: auto;
            padding: 10px;
        }

        .chat-message{
            max-width: 80%;
            min-width: 30%;
            margin: 0 0 20px 0;
            border: 1px solid #4e4e4e52;
            text-align: justify;
            text-justify: inter-character;
            padding: 15px;
        }

        .chat-message-mine{
            float: right;
            background-color: #f4ff686b;
            border-radius: 10px 10px 0 10px;
        }

        .chat-message-another{
            float: left;
            background-color: #bdffbd96;
            border-radius: 10px 10px 10px 0;
        }

        .chat-message-timestamp{
            float: right;
            font-size: 12px;
            padding: 5px 10px;
            margin: 0 0 0 10px;
            border: 1px solid #F2F2F2;
            border-radius: 5px
        }

        .chat-message-timestamp > p{
            margin: 0;
        }

        .chat-footer{
            background-color: #c8c8c8;
            height: 70px;
            min-height: 80px;
            width: calc(100% - 20px);
            padding: 10px;
            /*display: flex;*/
            border-radius: 0 0 5px 5px;
        }

        .txt-message-chat{
            float: left;
            height: 60px;
            min-height: 60px;
            max-height: 60px;
            width: calc(80% - 20px);
            min-width: calc(80% - 20px);
            max-width: calc(80% - 20px);
            padding: 10px;
            border-radius: 5px;
        }

        .btn-message-chat{
            float: right;
            border-radius: 5px;
            width: calc(20% - 15px);
            height: calc(50% - 5px);
            margin-bottom: 10px;
            background-color: dodgerblue;
            color: white;
            text-align: center;
        }

        .button-form{
            background-color: #1ab188;
            padding: 10px 20px;
            width: calc(100% - 40px);
            text-align: center;
        }

        .button-form:hover{
            /*transition-duration: 0.5s;*/
            -ms-transform: scale(1); /* IE 9 */
            -webkit-transform: scale(1); /* Safari */
            transform: scale(1);
            background-color: #1ab188a4;
        }

        .fieldset-box{
            background-color: #243f56;
            display: block;
            width: calc(100% - 31px);
            color: #FFFFFF;
            font-size: 17px;
            border: none;
        }

        .fieldset-box > div {
            margin: 10px 0;
        }

        .fieldset-box div input{
            width: calc(100% - 13px);
            height: 30px;
            font-size: 20px;
            padding: 10px 0 10px 10px ;
        }

        .fieldset-box > :last-child{
            margin: 20px 0 0px 0 !important;
            display: flex;
        }

        .fieldset-box > :last-child > a{
            margin: 10px 0;
            flex-grow: 1;
            color: #FFFFFF;
            text-decoration: none;
        }

    </style>
    <style type="text/css">
        @media (max-width: 1024px) {
            .fieldset-box > :last-child{
                display: block;
            }
        }
    </style>
</head>
<body>
    <nav>
    </nav>

    <main>
        <i class="material-icons">cloud</i>
        <div id="content" style="margin: 0 auto; width: 50%">
        </div>
    </main>

    <footer>

    </footer>

    <script type="text/javascript">
        divContent = $('#content');
        updateUI();
        firebase.initializeApp(fbaseConfig);
        fbaseAuth = firebase.auth();
        fbaseDatabase = firebase.database();

        function loginUser( email, password ) {
            fbaseAuth.signInWithEmailAndPassword( email, password ).catch(function( err ) {
                let errorCode = err.code;
                let errorMessage = err.message;
            });
            fbaseAuth.onAuthStateChanged(function ( user ) {
                console.log( user );
                if ( user.uid ){
                    fbaseAuthUser = user;
                } else {
                }
                updateUI();
            });
        }

        function createNewUserEmail( email, password ) {
            fbaseAuth.createUserWithEmailAndPassword( email, password ).catch( function (err) {
                let errorCode = err.code;
                let errorMessage = err.message;
            });
            fbaseAuth.onAuthStateChanged(function ( user ) {
                if ( user ){

                } else {

                }
            });
        }

        function updateUI() {
            if(fbaseAuthUser){
                $.get( "serverPages.php", {'logado': true}, function ( data ) {
                    divContent.html(data);
                    $('#chatBody').scrollTop(divContent.height());
                });
            }else{
                $.get( "serverPages.php", {'logado': false}, function ( data ) {
                    divContent.html(data);
                    $('#chatBody').scrollTop(divContent.height());
                });
            }
        }

    </script>
</body>
</html>

