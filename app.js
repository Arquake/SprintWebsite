function createEmployeCheck(field){
    return validFormField(field.elements['loginCreation'],2,32 ) && validFormField(field.elements['passwordCreation'],8,32 )
}


function connexionAttempt(field){
    return validFormField(field.elements['login'],2,32 ) && validFormField(field.elements['password'],8,32 )
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
        return false
    } else {
        field.style.backgroundColor = '#FFF'
    }
    return true
}