function connexionSubmitCheck( form ){
    var login = form.elements['login']
    var password = form.elements['password']

}

function invalidField(field){

}

// 
// Used for onBlur function in input
// Check if field's data have the right length
//
function validFormField( field, minLength, maxLength ){
    if ( field.value.length < minLength || field.value.length > maxLength ) {
        field.style.backgroundColor = '#d64848'
    } else {
        field.style.backgroundColor = '#FFF'
    }
}