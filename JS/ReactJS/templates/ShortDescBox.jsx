import { HTMLElement } from "../HTMLElement.mjs";

export class ShortDescBox extends React.Component{
    constructor(title, desc, logo, status, link_page){
        super();

        this.JQElement = $('div').attr({
            class : "ShortDescBox"
        }).css({
            border: '1px solid black',
            borderRadius: '30px'
        });

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

        this.JQElement.on('click', function () {
            window.location.href = link_page;
        });
    }

}