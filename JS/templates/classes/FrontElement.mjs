import { HTMLElement } from "../HTMLElement.mjs";
import { LeaveCross } from "./LeaveCross.mjs";

export class FrontElement extends HTMLElement{
    constructor(BackgroundId = false){
        super();

        //Permet de supprimer le fond sombre derrière également
        let id = "FrontElement";
        if(BackgroundId != false){
            id = BackgroundId;
        }
        this.JQElement = $('<div>').attr({
            class : "FrontElement",
            id : id
        });
        //Ajout de la croix pour quitter
        this.listElements.push(new LeaveCross("FrontElement"));
    }
}