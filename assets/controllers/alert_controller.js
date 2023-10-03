import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['alert'];

    connect() {
        this.alertTarget.textContent = 'Hello Stimulus! Edit me in assets/controllers/alert_controller.js';
    }
}