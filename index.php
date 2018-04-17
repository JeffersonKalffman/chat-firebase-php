<!DOCTYPE html>
<html>
<head>
    <title>Chat - kalffman</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.10.1/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.10.1/firebase-auth.js"></script>
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
</head>
<body>

    <div id="content" style="margin: 0 auto"></div>
    <script>
        divContent = $('#content');
        updateUI();
        firebase.initializeApp(fbaseConfig);
        fbaseAuth = firebase.auth();
        fbaseDatabase = firebase.database();

        function loginUser(email, password) {
            fbaseAuth.signInWithEmailAndPassword(email, password).catch(function(err) {
                let errorCode = err.code;
                let errorMessage = err.message;
            });
            fbaseAuth.onAuthStateChanged(function (user) {
                console.log(user);
                if (user.uid){
                    fbaseAuthUser = user;
                    alert('logado');
                } else {
                    alert('nada');
                }
                updateUI();
            });

        }

        function createNewUserEmail(email, password) {

            fbaseAuth.createUserWithEmailAndPassword(email,password).catch( function (err) {
                let errorCode = err.code;
                let errorMessage = err.message;
            });
            fbaseAuth.onAuthStateChanged(function (user) {
                if (user){
                } else {

                }

            });

        }

        function updateUI() {
            if(fbaseAuthUser){
                $.get("server.php",{
                    validate: true
                },function (data) {
                    console.log(data);
                    divContent.html(data);
                },'html');
            }else{
                $.get("server.php",{
                    validate: false
                },function (data) {
                    console.log(data);
                    divContent.html(data);
                },'html');
            }
        }
    </script>
</body>
</html>

