
let myForm = document.getElementById("myForm");


myForm.addEventListener('submit', function(e){
    let input_username = document.getElementById('username')
    let input_nom = document.getElementById('usr_nom');
    let input_prenom = document.getElementById('usr_prenomprenom');
    let input_email = document.getElementById('usr_mail');
    let input_phone = document.getElementById('usr_phone');
    let input_password = document.getElementById('password');
    let input_repassword = document.getElementById('repassword');
    let input_nationalite = document.getElementById('nationalite');

    let msg_username = document.getElementById("msg-username");
    let msg_nom = document.getElementById("msg-nom");
    let msg_prenom = document.getElementById("msg-prenom");
    let msg_mail = document.getElementById("msg-mail");
    let msg_password = document.getElementById("msg-password");
    let msg_repassword = document.getElementById("msg-repassword");
    let msg_telephone= document.getElementById("msg-phone");

    let Regex_nom = /^[a-zA-Z-\s]+$/;
    let Regex_prenom = /^[a-zA-Z-\s]+$/;
    let Regex_email = /^[a-zA-Z-\s]+$/;
    let Regex_phone = /^\+91\d{10}$/;
    const Regex_password=  /^[A-Za-z0-9]\w{8,}$/; //Au moins 8 caractère

    // Test du champs pour le username
    if(input_username.value.trim()== ""){
        msg_username.innerHTML = "Le champs Nom doit est requis";
        input_username.style.borderBlockColor = 'red';
        e.preventDefault();

    }else if(Regex_nom.test(input_username.value) == false){
        let myError = document.getElementById('error');
        msg_username.innerHTML = "Vous devez rentrer des lettres";
        input_username.style.borderBlockColor = 'red';
        e.preventDefault();
    }
    // Test du champs pour le nom
    if(input_nom.value.trim()== ""){
        msg_nom.innerHTML = "Le champs Nom doit est requis";
        input_nom.style.borderBlockColor = 'red';

        e.preventDefault();
    }else if(Regex_nom.test(input_username.value) == false){
        let myError = document.getElementById('error');
        msg_nom.innerHTML = "Vous devez rentrer des lettres";
        input_nom.style.borderBlockColor = 'red';
        e.preventDefault();
    }


    // Test du champs pour le prenom
    if(input_prenom.value.trim()== ""){
        msg_prenom.innerHTML = "Le champs Nom doit est requis";
        input_prenom.style.borderBlockColor = 'red';

        e.preventDefault();
    }else if(Regex_prenom.test(input_prenom.value) == false){
        let myError = document.getElementById('error');
        msg_prenom.innerHTML = "Vous devez rentrer des lettres";
        input_prenom.style.borderBlockColor = 'red';
        e.preventDefault();
    }

    // Test du password
    if(input_password.value != input_repassword.value){
        msg_password.innerHTML = "Les mots de passe doivent etre les meme";
        input_password.style.borderBlockColor = 'red';
        e.preventDefault();
    }
    else if (Regex_password.test(input_password.value) == false){
        msg_password.innerHTML = "Le mot de passe doit contenir au moins 8 caractères";
        input_password.style.borderBlockColor = 'red';
        e.preventDefault();
    }

});