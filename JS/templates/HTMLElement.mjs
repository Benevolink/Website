
/**
 * Liste des chemins relatifs ver les dossiers du serveur.
 */
class ListPathsElements{
    constructor(){
        this.CSS = "../../CSS/";
        this.Images = "../../media/img/";
    }
}

/**
 * Superclasse pour définir un élément du template
 */
export class HTMLElement extends ListPathsElements{

    constructor(){
        super();
        this.JQElement = $('<div>');
        this.listElements = [];
    }

    append(elt){
        if(elt instanceof HTMLElement)
            this.listElements.push(elt);
        else
            console.error("Erreur, vous essayez de push un élément du mauvais type");
    }

    show(JQParent){
        this.listElements.forEach((val)=>{
            val.show(this.JQElement);
        });
        JQParent.append(this.JQElement);
    }
}