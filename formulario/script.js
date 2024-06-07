
const form = document.getElementById("form");
const username = document.getElementById("username")
const email = document.getElementById("email")
const sexo = document.getElementById("sexo")
const adress = document.getElementById("adress");
const birthday = document.getElementById("birthday");
const phone = document.getElementById("phone");



form.addEventListener("submit", (event) => {
  event.preventDefault();

  checkForm();
})

email.addEventListener("blur", () => {
  checkInputEmail();
})


username.addEventListener("blur", () => {
  checkInputUsername();
})

sexo.addEventListener("blur", () => {
  checkInputSexo();
})

adress.addEventListener("blur", () => {
  checkInputAdress();
})

birthday.addEventListener("blur", () => {
  checkInputBirthday();
})

phone.addEventListener("blur", () => {
  checkInputPhone();
})


function checkInputUsername(){
  const usernameValue = username.value;

  if(usernameValue === ""){
    errorInput(username, "Preencha seu nome!")
  }else{
    const formItem = username.parentElement;
    formItem.className = "form-content"
  }
}

function checkInputEmail(){
  const emailValue = email.value;
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  if(emailValue === ""){
    errorInput(email, "O email é obrigatório.")
  } else if (!emailRegex.test(emailValue)) {
    errorInput(email, "Por favor, insira um email válido.");
  } else {
    const formItem = email.parentElement;
    formItem.className = "form-content"
  }
}

function checkInputSexo(){
  const sexoValue = sexo.value;

  if(sexoValue === ""){
    errorInput(sexo, "O sexo ou gênero é obrigatório.")
  }else{
    const formItem = sexo.parentElement;
    formItem.className = "form-content"
  }
}

function checkInputAdress(){
  const adressValue = adress.value;

  if(adressValue === ""){
    errorInput(adress, "O endereço é obrigatório.")
  }else{
    const formItem = adress.parentElement;
    formItem.className = "form-content"
  }
}

birthday.addEventListener("input", (event) => {
  formatBirthday(event.target);
});

function formatBirthday(input) {
  const value = input.value.replace(/\D/g, ''); // Remove qualquer caractere que não seja dígito
  let formattedValue = '';

  if (value.length > 4) {
    formattedValue = `${value.substring(0, 2)}/${value.substring(2, 4)}/${value.substring(4, 8)}`;
  } else if (value.length > 2) {
    formattedValue = `${value.substring(0, 2)}/${value.substring(2, 4)}`;
  } else {
    formattedValue = value;
  }

  input.value = formattedValue;
}

function formatPhone(input) {
  const value = input.value.replace(/\D/g, ''); // Remove qualquer caractere que não seja dígito
  let formattedValue = '';

  if (value.length > 6) {
    formattedValue = `(${value.substring(0, 2)}) ${value.substring(2, 7)}-${value.substring(7, 11)}`;
  } else if (value.length > 2) {
    formattedValue = `(${value.substring(0, 2)}) ${value.substring(2, 7)}`;
  } else if (value.length > 0) {
    formattedValue = `(${value.substring(0, 2)}`;
  } else {
    formattedValue = value;
  }

  input.value = formattedValue;
}


function checkForm(){
  checkInputUsername();
  checkInputEmail();
  checkInputSexo();
  checkInputAdress();
  checkInputBirthday();
  checkInputPhone();

  const formItems = form.querySelectorAll(".form-content")

  const isValid = [...formItems].every( (item) => {
    return item.className === "form-content"
  });

  if(isValid){
    alert("CADASTRADO COM SUCESSO!")
  }

}


function errorInput(input, message){
  const formItem = input.parentElement;
  const textMessage = formItem.querySelector("a")

  textMessage.innerText = message;

  formItem.className = "form-content error"

}