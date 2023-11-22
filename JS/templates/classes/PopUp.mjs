import { HTMLElement } from "../HTMLElement.mjs";
import { FrontElement } from "./FrontElement.mjs";

export class PopUp extends HTMLElement{
    constructor(zIndex = 9000){
        super();
        this.JQElement = $('div').attr({
            id : "PopUpBackground"
        }).css({
            zIndex : zIndex
        });
        this.append(new FrontElement("PopUpBackground"));
    }
}