

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
// si la valeur est négative la mettre à 0
//

function soldeCheckPositive( field ) {
    if ( field.value > 0 ) {
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


//
// NV
//
// creation de contrat vérifie si les charactère sont tous vérifiés
//

function creationContratOuverture(form) {

    elements = form.elements

    if ( elements[2].value.toString().length == 0 ) {
        elements[2].value = 0
        alert('veuillez rentrer une valeur valide')
        event.preventDefault()
    }

}


//
// NV
//
//
//

function getFiveElementsVenir(){
    i=0;
    list="";

    if ( this.arrVenir != undefined ) {
        if(this.indexOfPageRdvVenir > 0) {
            list = '<input type="image" src="View/style/assets/Left-Arrow.png" class="smallarrowNextPage" id="rdvVenirMinus" style="visibility: visible; cursor: pointer;" onClick="minusVenirButtonEvent()">';
        } else {
            list = '<input type="image" src="View/style/assets/Left-Arrow.png" class="smallarrowNextPage" id="rdvVenirMinus" style="visibility: hidden">';
        }
    
        while( i < 5 && this.indexOfPageRdvVenir*5+i < this.arrVenir.length ) {
            list += '<div class="bulleDansInfoRdvSynthèse" style="cursor: pointer;" onClick="showSynthesisOfRdv( '+ this.indexOfPageRdvVenir*5+i +', 1 )">'+
                '<div class="horraireSynthese">'+
                    this.arrVenir[this.indexOfPageRdvVenir*5+i][1]+
                    '<br>'+
                    this.arrVenir[this.indexOfPageRdvVenir*5+i][2]+
                    '<br>'+
                    this.arrVenir[this.indexOfPageRdvVenir*5+i][3]+
                '</div>'+
                '<div class="inbubbleSynthese">'+
                    'idRDV : '+ this.arrVenir[this.indexOfPageRdvVenir*5+i][0] +
                '</div>'+
                '<div class="inbubbleSynthese">'+
                    'motif : '+ this.arrVenir[this.indexOfPageRdvVenir*5+i][5] +
                '</div>'+
            '</div>';
            i+=1;
        };
        
        if( this.arrVenir.length > this.indexOfPageRdvVenir*5+i ) {
            list += '<input type="image" src="View/style/assets/Right-Arrow.png" class="smallarrowNextPage" id="rdvVenirAdd" style="visibility: visible; cursor: pointer;" onClick="addVenirButtonEvent()"></input>';
        } else {
            list += '<input type="image" src="View/style/assets/Right-Arrow.png" class="smallarrowNextPage" id="rdvVenirAdd" style="visibility: hidden"></input>';
        }
    }

    document.getElementById("RdvVenir").innerHTML = list
}


//
// NV
//
//
//

function getFiveElementsPasse(){
    i=0;
    list="";

    if ( this.arrPasse != undefined ) {
        if(this.indexOfPageRdvPasse > 0 ) {
            list = '<input type="image" src="View/style/assets/Left-Arrow.png" class="smallarrowNextPage" id="rdvVenirMinus" style="visibility: visible; cursor: pointer;" onClick="minusPasseButtonEvent()">';
        } else {
            list = '<input type="image" src="View/style/assets/Left-Arrow.png" class="smallarrowNextPage" id="rdvVenirMinus" style="visibility: hidden">';
        }
    
        while( i < 5 && this.indexOfPageRdvPasse*5+i < this.arrPasse.length ) {
            list += '<div class="bulleDansInfoRdvSynthèse" style="cursor: pointer;" onClick="showSynthesisOfRdv( '+ (parseInt(this.indexOfPageRdvPasse*5)+i) +', 2 )">'+
                '<div class="horraireSynthese">'+ 
                    this.arrPasse[this.indexOfPageRdvPasse*5+i][1]+
                    '<br>'+
                    this.arrPasse[this.indexOfPageRdvPasse*5+i][2]+
                    '<br>'+
                    this.arrPasse[this.indexOfPageRdvPasse*5+i][3]+
                '</div>'+
                '<div class="inbubbleSynthese">'+
                    'idRDV : '+ this.arrPasse[this.indexOfPageRdvPasse*5+i][0] +
                '</div>'+
                '<div class="inbubbleSynthese">'+
                    'motif : '+ this.arrPasse[this.indexOfPageRdvPasse*5+i][5] +
                '</div>'+
            '</div>';
            i+=1;
        };
        
        if( this.arrPasse.length > this.indexOfPageRdvPasse*5+i ) {
            list += '<input type="image" src="View/style/assets/Right-Arrow.png" class="smallarrowNextPage" id="rdvVenirAdd" style="visibility: visible; cursor: pointer;" onClick="addPasseButtonEvent()"></input>';
        } else {
            list += '<input type="image" src="View/style/assets/Right-Arrow.png" class="smallarrowNextPage" id="rdvVenirAdd" style="visibility: hidden"></input>';
        }
    }

    
    document.getElementById("RdvPasse").innerHTML = list
}


//
// NV
//
//
//

function minusVenirButtonEvent() {
    if( this.indexOfPageRdvVenir > 0){
        this.indexOfPageRdvVenir-=1;
        getFiveElementsVenir();
    }
}


//
// NV
//
//
//

function addVenirButtonEvent() {
    if( this.indexOfPageRdvVenir*5 < this.arrVenir.length ){
        this.indexOfPageRdvVenir+=1;
        getFiveElementsVenir();
    }
}


//
// NV
//
//
//

function minusPasseButtonEvent() {
    if( this.indexOfPageRdvPasse > 0){
        this.indexOfPageRdvPasse-=1;
        getFiveElementsPasse();
    }
}


//
// NV
//
//
//

function addPasseButtonEvent() {
    if( this.indexOfPageRdvPasse*5 < this.arrPasse.length ){
        this.indexOfPageRdvPasse+=1;
        getFiveElementsPasse();
    }
}


//
// NV
//
// rdvList = 1 : venir | 2 : passe
//

function showSynthesisOfRdv( rdvId, rdvList ) {

    console.log(rdvId)

    if ( rdvList == 1 ) {
        rdvarr = this.arrVenir[rdvId]
    } else {
        rdvarr = this.arrPasse[rdvId]
    }
    
    list = '<div class="leftSyntheseInfo">'+
        'Jour : '+ rdvarr[1] +
        '<br>'+
        'heure de début : '+ rdvarr[2] +
        '<br>'+
        'heure de fin : '+ rdvarr[3] +
        '</div>'+
        '<div class="rightSyntheseInfo">'+
        '    Motif : '+ rdvarr[5] +
        '    <br>'+
        '    Liste Pièces Necessaire : <textarea class="rightSyntheseInfoTextarea" disabled>'+ rdvarr[6] +'</textarea>'+
        '</div>';

    console.log(list)

    document.getElementById("infoSyntheseBlock").innerHTML = list
}