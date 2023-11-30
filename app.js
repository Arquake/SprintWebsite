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
    console.log(field.value)
    if ( field.value.maxLength > maxLength || field.value.minLength < minLength ) {
        field.bgColor = 'red'
    }
}