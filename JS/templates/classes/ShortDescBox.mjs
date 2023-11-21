import { HTMLElement } from "../HTMLElement.mjs";

export class ShortDescBox extends HTMLElement{
    constructor(title, desc, logo, status, link_page){
        super();

        this.JQElement = $('div').attr({
            id : "ShortDescBox"
        })

        const titleElement = $('<h2>').text(title);
        this.JQElement.append(titleElement);

        const descElement = $('<p>').text(desc);
        this.JQElement.append(descElement);

        const logoElement = $('<img>').attr({
            src: logo,
            alt: "logo"
        });
        this.JQElement.append(logoElement);

        const statusElement = $('<span>').text(status);
        this.JQElement.append(statusElement);

        if (link) {
            this.JQElement.on('click', function () {
                window.location.href = link;
            });
        }s

    }

}