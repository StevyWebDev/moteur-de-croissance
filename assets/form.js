let changeName = document.querySelector('#changeName');
            
changeName.addEventListener('click', function() {
    let containter = document.querySelector('#contentForm');

    containter.innerHTML = `
    <div id="form-account">
        <form action="{{ path('update_name') }}" method="post">
            {{ render(path('update_name'))}}
        </form>
    </div>
`
})

let changeFirstname = document.querySelector('#changeFirstname');
    
changeFirstname.addEventListener('click', function() {
    let containter = document.querySelector('#contentForm');

    containter.innerHTML = `
    <div id="form-account">
        <form action="{{ path('update_firstname') }}" method="post">
            {{ render(path('update_firstname'))}}
        </form>
    </div>
`
})

let changeEmail = document.querySelector('#changeEmail');
    
changeEmail.addEventListener('click', function() {
    let containter = document.querySelector('#contentForm');

    containter.innerHTML = `
    <div id="form-account">
        <form action="{{ path('update_email') }}" method="post">
            {{ render(path('update_email'))}}
        </form>
    </div>
`
})

let changePhone = document.querySelector('#changePhone');
    
changePhone.addEventListener('click', function() {
    let containter = document.querySelector('#contentForm');

    containter.innerHTML = `
    <div id="form-account">
        <form action="{{ path('update_phone') }}" method="post">
            {{ render(path('update_phone'))}}
        </form>
    </div>
`
})

let changePassword = document.querySelector('#changePassword');
    
changePassword.addEventListener('click', function() {
    let containter = document.querySelector('#contentForm');

    containter.innerHTML = `
    <div id="form-account">
        <form action="{{ path('update_password') }}" method="post">
            {{ render(path('update_password'))}}
        </form>
    </div>
`
})

function deleteForm() {
    let containter = document.querySelector('#contentForm');
    containter.innerHTML = ""
}