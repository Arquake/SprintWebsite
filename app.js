

//
// NV
//
// 
//

function createEmployeCheck(field){
    return validFormField(field.elements['loginCreation'],2,32 ) && validFormField(field.elements['passwordCreation'],8,32 )
}


//
// NV
//
// 
//

function connexionAttempt(field){
    return validFormField(field.elements['login'],2,32 ) && validFormField(field.elements['password'],8,32 )
}


//
// NV
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


//
// NV
//
// si le découvert est positif mettre la valeur en négatif
//

function decouvertCheckPositive( field ) {
    if ( field.value > 0 ) {
        field.value = -field.value
    }
}


//
// NV
//
// si la valeur est négative la mettre en positif
//

function plafondInterestCheckNegative( field ) {
    if ( field.value < 0 ) {
        field.value = -field.value
    }
}


//
// NV
//
// si la valeur est négative la mettre à 0
//

function soldeCheckNegative( field ) {
    if ( field.value < 0 ) {
        field.value = 0
    }
}


//
// NV
//
// modification employe du directeur si tout les champs ne sont pas rempli
//

function modifierEmploye(form) {
    var form = document.getElementById('modificationEmploye')

    if ( form[1].value.length == 0 || form[2].value.length == 0 || form[3].value.length == 0 || ( form[4].checked && form[5].value.length == 0 )) {
        alert('Veuillez remplir tout les champs')
        event.preventDefault()
    }
    
}


//
// NV
//
// creation de compte vérifie si les charactère sont tous vérifiés
//

function creationCompteInformationCheck(form) {
    elements = form.elements

    if ( elements[2].checked && elements[3].value.toString().length == 0 ) {
        elements[3].value = 0
    }

    if ( elements[4].checked && elements[5].value.toString().length == 0 ) {
        elements[5].value = 0
    }

    if ( elements[6].checked && elements[7].value.toString().length == 0 ) {
        elements[7].value = 0
    }

    if ( elements[8].value.toString().length == 0 ) {
        elements[8].value = 0
    }
}