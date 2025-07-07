import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { MenuItem } from 'primeng/api';
import { Publicidade } from 'src/app/interfaces/publicidade';

@Component({
  selector: 'app-card-publicidade',
  templateUrl: './card-publicidade.component.html',
  styleUrls: ['./card-publicidade.component.css'],
})
export class CardPublicidadeComponent implements OnInit {
  @Input() publicidade!: Publicidade;
  @Input() publicidadeAtual: boolean = false;
  @Output() onEditar = new EventEmitter<Publicidade>();
  @Output() onEncerrar = new EventEmitter<number>();

  items: MenuItem[] = [];

  ngOnInit() {
    this.items = [
      {
        label: 'Editar',
        icon: 'pi pi-fw pi-pencil',
        command: () => {
          this.editar();
        },
      },
      {
        label: 'Encerrar',
        icon: 'pi pi-fw pi-times-circle',
        styleClass: 'menu-item-close',
        command: () => {
          this.encerrar();
        },
      },
    ];
  }

  editar() {
    this.onEditar.emit(this.publicidade);
  }

  encerrar() {
    this.onEncerrar.emit(this.publicidade.id);
  }

  redirect() {
    window.open(this.publicidade.botao_link, '_blank');
  }

  openPubli(event: MouseEvent, headeraction: HTMLElement) {
    if (headeraction.contains(event.target as Node)) {
      return;
    }
    this.redirect();
  }
}
