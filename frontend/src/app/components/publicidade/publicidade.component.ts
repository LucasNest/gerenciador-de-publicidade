import { Component, OnInit, ViewChild } from '@angular/core';
import { ModalPublicidadeComponent } from './modal-publicidade/modal-publicidade.component';
import { EstadosService } from 'src/app/services/estados/estados.service';
import { PublicidadesService } from 'src/app/services/publicidades/publicidades.service';
import { Estado } from 'src/app/interfaces/estado';
import { Publicidade } from 'src/app/interfaces/publicidade';
import { debounceTime, forkJoin, Subscription } from 'rxjs';
import { MessageService } from 'primeng/api';
import { FormControl } from '@angular/forms';

@Component({
  selector: 'app-publicidade',
  templateUrl: './publicidade.component.html',
  styleUrls: ['./publicidade.component.css'],
})
export class PublicidadeComponent implements OnInit {
  private subscriptions: Subscription = new Subscription();
  @ViewChild(ModalPublicidadeComponent)
  modalPublicidadeComponent!: ModalPublicidadeComponent;

  inputPublicidade = new FormControl<string>('');
  multiSelectEstados = new FormControl<string[]>([]);
  publicidades: Publicidade[] = [];
  publicidadeAtiva?: Publicidade;
  estados: Estado[] = [];

  isLoading: boolean = false;

  constructor(
    private estadosService: EstadosService,
    private publicidadesService: PublicidadesService,
    private messageService: MessageService
  ) {}

  ngOnInit(): void {
    const inputSub = this.inputPublicidade.valueChanges
      .pipe(debounceTime(500))
      .subscribe(() => {
        this.filterPublicidade();
      });

    const multiSelectEstadosSub =
      this.multiSelectEstados.valueChanges.subscribe(() => {
        this.filterPublicidade();
      });

    this.subscriptions.add(multiSelectEstadosSub);
    this.subscriptions.add(inputSub);

    this.loadPage();
  }

  ngOnDestroy(): void {
    this.subscriptions.unsubscribe();
  }

  loadPage() {
    this.isLoading = true;

    const estados$ = this.estadosService.getEstados();
    const publicidades$ = this.publicidadesService.getPublicidade();

    const loadSub = forkJoin([estados$, publicidades$]).subscribe({
      next: ([estados, publicidades]) => {
        this.estados = estados.estados;
        this.publicidades = publicidades.publicidades;
        this.publicidadeAtiva = publicidades.publicidade_ativas[0];
      },
      error: (err) => {
        this.messageService.add({
          severity: 'error',
          summary: 'Erro',
          detail: 'Erro ao carregar pagina',
        });
        this.isLoading = false;
      },
      complete: () => {
        this.isLoading = false;
      },
    });

    this.subscriptions.add(loadSub);
  }

  openModal(publicidade?: Publicidade) {
    if (this.estados) {
      this.modalPublicidadeComponent.open(publicidade);
    } else {
      this.messageService.add({
        severity: 'error',
        summary: 'Erro',
        detail: 'Modal Indisponivel no momento',
      });
    }
  }

  encerrar(id: number) {
    this.isLoading = true;
    this.publicidadesService.deletePublicidade(id).subscribe({
      next: () => {
        this.messageService.add({
          severity: 'success',
          summary: 'Successo',
          detail: 'Publicidade encerrada com sucesso',
        });
      },
      error: () => {
        this.messageService.add({
          severity: 'error',
          summary: 'Erro',
          detail: 'Erro ao encerrar publicidade',
        });
      },
      complete: () => {
        this.isLoading = false;
        this.loadPage();
      },
    });
  }

  filterPublicidade() {
    let search = this.inputPublicidade.value ?? '';
    let estado = this.multiSelectEstados.value;
    const filterPublicidade = this.publicidadesService
      .getPublicidade(search, estado)
      .subscribe({
        next: (publicidades) => {
          this.publicidades = publicidades.publicidades;
          this.publicidadeAtiva = publicidades.publicidade_ativas[0];
        },
      });

    this.subscriptions.add(filterPublicidade);
  }
}
