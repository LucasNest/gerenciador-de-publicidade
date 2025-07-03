import { Component, OnInit } from '@angular/core';
import { MenuItem } from 'primeng/api';

@Component({
  selector: 'app-card-publicidade',
  templateUrl: './card-publicidade.component.html',
  styleUrls: ['./card-publicidade.component.css'],
})
export class CardPublicidadeComponent implements OnInit {
  items: MenuItem[] = [];

  teste = 'teste'

  ngOnInit() {
    this.items = [
      {
        label: 'Editar',
        icon: 'pi pi-fw pi-pencil',
      },
      {
        label: 'Encerrar',
        icon: 'pi pi-fw pi-times-circle',
        styleClass: 'menu-item-close',
      },
    ];
  }
}
