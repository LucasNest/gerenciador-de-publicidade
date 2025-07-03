import { Component, OnInit, ViewChild } from '@angular/core';
import { ModalPublicidadeComponent } from './modal-publicidade/modal-publicidade.component';

@Component({
  selector: 'app-publicidade',
  templateUrl: './publicidade.component.html',
  styleUrls: ['./publicidade.component.css'],
})
export class PublicidadeComponent implements OnInit {
  filterStatesValue: any;
  states: any;

  @ViewChild(ModalPublicidadeComponent)
  modalPublicidadeComponent!: ModalPublicidadeComponent;

  ngOnInit(): void {}

  filterStates() {}

  openModal() {
    this.modalPublicidadeComponent.open();
  }
}
