import { HTMLElement } from "../HTMLElement.mjs";

export class ShortDescBox extends HTMLElement{
    constructor(title, desc, logo, status){
        super();

        this.JQElement = $('div').attr({
            id : "ShortDescBox"
        })

        const titleElement = $('<h2>').text(title);
        this.append(titleElement);

        const descElement = $('<p>').text(desc);
        this.append(descElement);

        const logoElement = $('<img>').attr({
            src: logo,
            alt: "Logo"
        });
        this.append(logoElement);

        const statusElement = $('<span>').text(status);
        this.append(statusElement);

    }

}