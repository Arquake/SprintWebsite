function createEmployeCheck(this){
    
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