import { HTMLElement } from "../HTMLElement.js";
import { FrontElement } from "./FrontElement.js";

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