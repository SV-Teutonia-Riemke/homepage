import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    initialize() {
        this.element.addEventListener('click', function (event) {
            event.preventDefault();

            if(! window.confirm('Wollen Sie diesen Item wirklich löschen')) {
                return;
            }

            const target = event.currentTarget as HTMLElement;
            const link = target.getAttribute('href');

            if(link === null) {
                return;
            }

            location.href = link;
        })
    }
}
