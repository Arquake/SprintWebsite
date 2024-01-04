

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
// met les 5 éléments dans la zone de rendez-vous à venir
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
            list += '<div class="bulleDansInfoRdvSynthese" style="cursor: pointer;" onClick="showSynthesisOfRdv( '+ this.indexOfPageRdvVenir*5+i +', 1 )">'+
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
// met les 5 éléments dans la zone de rendez-vous passez
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
            list += '<div class="bulleDansInfoRdvSynthese" style="cursor: pointer;" onClick="showSynthesisOfRdv( '+ (parseInt(this.indexOfPageRdvPasse*5)+i) +', 2 )">'+
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
// page précédente dans les RDV à venir
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
// page suivante dans les RDV à venir
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
// page précédente dans les RDV passés
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
// page suivante dans les RDV passés
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

    document.getElementById("infoSyntheseBlock").innerHTML = list
}


//
// NV
//
// appelé par une div de compte et affiche le produit clos dans la zone réservé
//

function setProduitClos( idCompte ) {

    if ( idCompte in this.transaction ) {
        list = "";
        for ( i = 0 ; i < this.transaction[idCompte].length ; i++ ) {
            list += '<div class="produitClosBubble">id : '+this.transaction[idCompte][i][0]+' | ';
            if ( this.transaction[idCompte][i][1] > 1 ) {
                list += 'dépot '
            } else {
                list += 'retrait '
            }
            list += this.transaction[idCompte][i][1]+'</div>';
        }
        document.getElementById("produitClos").innerHTML = list;
    } else {
        document.getElementById("produitClos").innerHTML = "";
    }
}


//
// NV
//
// affiche une selection de plage de dates
//

function plageDate( checkBoxId, divId, statsName ) {

    divToChange = document.getElementById( divId );

    if ( divToChange == undefined ) {
        divCreation = document.createElement('div');
        divCreation.id = divId;
        document.getElementById( checkBoxId ).after(divCreation);
        document.getElementById( divId ).innerHTML ='<p>'+
        '<label for="dateDebut">Date De Début</label><input type="date" name="dateDebutStats'+statsName+'" required max="'+this.date+'"></p>'+
        '<p><label for="dateFin">Date De Fin</label><input type="date" name="dateFinStats'+statsName+'" required max="'+this.date+'"></p>';
    } else {
        document.getElementById( divId ).outerHTML = '';
    }
}


//
// NV
//
// affiche une selection de date
//

function dateSelection( checkBoxId, divId, statsName ) {

    divToChange = document.getElementById( divId );

    if ( divToChange == undefined ) {
        divCreation = document.createElement('div');
        divCreation.id = divId;
        document.getElementById( checkBoxId ).after(divCreation);
        document.getElementById( divId ).innerHTML ='<p>'+
        '<label for="dateDebut">Date De Fin</label><input type="date" name="dateStats'+statsName+'" required max="'+this.date+'"></p>';
    } else {
        document.getElementById( divId ).outerHTML = '';
    }
}


//
// NV
//
// modifie les boutons disponible lors de changement d'information client
//

function modificationClientEditSubmit( validation ) {

    divToChange = document.getElementById( "modification" );

    nom = document.getElementById( "nomClientModification" );

    prenom = document.getElementById( "prenomClientModification" );

    date = document.getElementById( "dateNaissanceClientModification" );

    event.preventDefault();

    if ( validation ) {
        divToChange.innerHTML = '<p><input class="submitFormInput" type="submit" value="Valider" name="ValiderModificationClientSubmit"></p>'+
                                '<p><input class="submitFormInput" type="submit" value="Editer" name="ReModificationClientSubmit" onClick="modificationClientEditSubmit(false)"></p>';
        
        nom.disabled = true;
        prenom.disabled = true;
        date.disabled = true;

    } else {
        divToChange.innerHTML = '<p><input class="submitFormInput" type="submit" value="Modifier" name="ModificationClientSubmit" onClick="modificationClientEditSubmit(true)"></p>';
        nom.disabled = false;
        prenom.disabled = false;
        date.disabled = false;
    }
}


//
// NV
//
// réactive les champ pour être envoyé
//

function modificationSubmit() {

    document.getElementById( "nomClientModification" ).disabled = false;

    document.getElementById( "prenomClientModification" ).disabled = false;

    document.getElementById( "dateNaissanceClientModification" ).disabled = false;
}

//
// MP
//
// modifie les boutons disponible lors de changement d'information motif
//

function modificationMotifEditSubmit( validation ) {

    divToChange = document.getElementById( "modification" );

    motif = document.getElementById( "motifModification" );

    pieces = document.getElementById( "pieceMotifModification" );

    event.preventDefault();

    if ( validation ) {
        divToChange.innerHTML = '<p><input class="submitFormInput" type="submit" value="Valider" name="ValiderModificationMotifSubmit"></p>'+
                                '<p><input class="submitFormInput" type="submit" value="Editer" name="ReModificationMotifSubmit" onClick="modificationMotifEditSubmit(false)"></p>';
        
        motif.disabled = true;
        pieces.disabled = true;

    } else {
        divToChange.innerHTML = '<p><input class="submitFormInput" type="submit" value="Modifier" name="ModificationMotifSubmit" onClick="modificationMotifEditSubmit(true)"></p>';
        
        motif.disabled = false;
        pieces.disabled = false;
    }
}

//
// MP
//
// réactive les champ pour être envoyé
//

function modificationMotifSubmit() {

    document.getElementById( "motifModification" ).disabled = false;

    document.getElementById( "pieceMotifModification" ).disabled = false;
}


//
// MP
//
// modifie les boutons disponible lors de changement d'information du type compte
//

function modificationTypeCompteEditSubmit( validation ) {

    divToChange = document.getElementById( "modification" );

    type = document.getElementById( "typeCompteModification" );

    event.preventDefault();

    if ( validation ) {
        divToChange.innerHTML = '<p><input class="submitFormInput" type="submit" value="Valider" name="ValiderModificationTypeCompteSubmit"></p>'+
                                '<p><input class="submitFormInput" type="submit" value="Editer" name="ReModificationTypeCompteSubmit" onClick="modificationTypeCompteEditSubmit(false)"></p>';
        
        type.disabled = true;

    } else {
        divToChange.innerHTML = '<p><input class="submitFormInput" type="submit" value="Modifier" name="ModificationTypeCompteSubmit" onClick="modificationTypeCompteEditSubmit(true)"></p>';
        
        type.disabled = false;
    }
}

//
// MP
//
// réactive les champ pour être envoyé
//

function modificationTypeCompteSubmit() {

    document.getElementById( "typeCompteModification" ).disabled = false;
}

//
// MP
//
// modifie les boutons disponible lors de changement d'information du type contrat
//

function modificationTypeContratEditSubmit( validation ) {

    divToChange = document.getElementById( "modification" );

    type = document.getElementById( "typeContratModification" );

    event.preventDefault();

    if ( validation ) {
        divToChange.innerHTML = '<p><input class="submitFormInput" type="submit" value="Valider" name="ValiderModificationTypeContratSubmit"></p>'+
                                '<p><input class="submitFormInput" type="submit" value="Editer" name="ReModificationTypeContratSubmit" onClick="modificationTypeContratEditSubmit(false)"></p>';
        
        type.disabled = true;

    } else {
        divToChange.innerHTML = '<p><input class="submitFormInput" type="submit" value="Modifier" name="ModificationTypeContratSubmit" onClick="modificationTypeContratEditSubmit(true)"></p>';
        
        type.disabled = false;
    }
}

//
// MP
//
// réactive les champ pour être envoyé
//

function modificationTypeContratSubmit() {

    document.getElementById( "typeContratModification" ).disabled = false;
}