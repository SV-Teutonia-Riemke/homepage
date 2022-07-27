import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['input', 'preview'];

    render(event) {
        const rendered = this.inputTarget.value;
        this.previewTarget.innerHTML = rendered;
    }
}
