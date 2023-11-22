import { HTMLElement } from "../HTMLElement.mjs";

export class LeaveCross extends HTMLElement{
    constructor(targetId){
        super();
        this.targetId = targetId;
        this.JQElement = $('img').attr({
            alt : 'image_fermer_boite',
            src : this.Images+'croix.jpg',
            class : 'LeaveCross'
        }).click((event)=>{
            event.preventDefault();
            $("#"+targetId).remove();
        });
    }
}