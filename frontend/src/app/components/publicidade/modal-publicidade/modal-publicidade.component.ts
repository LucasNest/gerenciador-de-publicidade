import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import {
  FormBuilder,
  FormControl,
  FormGroup,
  Validators,
} from '@angular/forms';
import { MessageService } from 'primeng/api';
import { Estado } from 'src/app/interfaces/estado';
import { Publicidade } from 'src/app/interfaces/publicidade';
import { PublicidadesService } from 'src/app/services/publicidades/publicidades.service';

@Component({
  selector: 'app-modal-publicidade',
  templateUrl: './modal-publicidade.component.html',
  styleUrls: ['./modal-publicidade.component.css'],
})
export class ModalPublicidadeComponent implements OnInit {
  @Input() estados: Estado[] = [];
  @Output() onSavePublicidade = new EventEmitter<any>();

  title!: string;
  visible: boolean = false;
  imageError?: boolean;
  minDate: Date = new Date();
  isLoading: boolean = false;

  publicidadeForm!: FormGroup;

  file: File | null = null;
  imageUrl: string | null = null;
  imageName: string | null = null;

  multiSelectEstados = new FormControl<number[]>([], Validators.required);
  dt_inicio = new FormControl<Date | null>(null, Validators.required);
  dt_fim = new FormControl<Date | null>(
    { value: null, disabled: true },
    Validators.required
  );

  constructor(
    private fb: FormBuilder,
    private publicidadesService: PublicidadesService,
    private messageService: MessageService
  ) {
    this.publicidadeForm = this.fb.group({
      id: [null],
      titulo: ['', Validators.required],
      descricao: ['', Validators.required],
      imagem: ['', Validators.required],
      botao_link: ['', Validators.required],
      titulo_botao_link: ['', Validators.required],
    });
  }

  ngOnInit(): void {
    this.dt_inicio.valueChanges.subscribe((data: any) => {
      if (data) {
        this.dt_fim.enable();
      } else {
        this.dt_fim.disable();
      }
    });
  }

  open(publicidade?: Publicidade) {
    if (publicidade) {
      this.title = 'Editar publicidade';
      this.patchFormValue(publicidade);
    } else {
      this.title = 'Nova publicidade';
      this.resetForm();
    }
    this.visible = true;
  }

  onFileSelected(event: Event): void {
    const input = event.target as HTMLInputElement;
    if (input.files && input.files.length > 0) {
      this.setFile(input.files[0]);
    }
  }

  onDragOver(event: DragEvent) {
    event.preventDefault();
  }

  onDrop(event: DragEvent) {
    event.preventDefault();

    const files = event.dataTransfer?.files;
    if (files && files.length > 0) {
      this.setFile(files[0]);
    }
  }

  private setFile(file: File): void {
    this.file = file;
    this.imageName = this.file.name;

    if (file.size > 4 * 1024 * 1024) {
      this.messageService.add({
        severity: 'error',
        summary: 'Erro',
        detail: 'A imagem não pode ultrapassar 4MB.',
      });
      this.removeFile();
      return;
    }

    const extensao = file.name.split('.').pop()?.toLowerCase();
    const permitidas = ['jpg', 'jpeg', 'png', 'webp'];

    if (!extensao || !permitidas.includes(extensao)) {
      this.messageService.add({
        severity: 'error',
        summary: 'Formato inválido',
        detail:
          'Somente imagens nos formatos JPG, JPEG, PNG ou WEBP são permitidas.',
      });
      this.removeFile();
      return;
    }

    if (this.file) {
      const reader = new FileReader();
      reader.onload = (e) => (
        (this.imageUrl = e.target?.result as string),
        this.publicidadeForm.get('imagem')?.setValue(e.target?.result as string)
      );
      reader.readAsDataURL(this.file);
    }
  }

  removeFile(): void {
    this.file = null;
    this.imageUrl = null;
    this.imageName = null;
    this.publicidadeForm.get('imagem')?.reset();
  }

  patchFormValue(publicidade: Publicidade) {
    this.publicidadeForm.patchValue(publicidade);
    const estadosIds = publicidade.estados.map((estado: any) => {
      return estado.id;
    });
    this.multiSelectEstados.setValue(estadosIds);
    this.dt_inicio.setValue(new Date(publicidade.dt_inicio));
    this.dt_fim.setValue(new Date(publicidade.dt_fim));
    this.imageUrl = publicidade.imagem;

    const nomeComUuid = publicidade.imagem.split('/').pop() || '';
    const nomeSemUuid = nomeComUuid.replace(
      /^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}-/,
      ''
    );

    this.imageName = nomeSemUuid;
  }

  resetForm() {
    this.publicidadeForm.reset();
    this.multiSelectEstados.reset();
    this.dt_inicio.reset();
    this.dt_fim.reset();
    this.imageUrl = null;
    this.imageName = null;
  }

  savePublicidade() {
    if (
      this.publicidadeForm.invalid ||
      this.multiSelectEstados.invalid ||
      this.dt_inicio.invalid ||
      this.dt_fim.invalid ||
      !this.imageUrl
    ) {
      this.publicidadeForm.markAllAsTouched();
      this.multiSelectEstados.markAsTouched();
      this.dt_inicio.markAsTouched();
      this.dt_fim.markAsTouched();
      this.imageError = true;
      return;
    }
    const formValue = { ...this.publicidadeForm.value };

    const idPublicidade = formValue.id;
    delete formValue.id;

    const publicidade = {
      ...formValue,
      dt_inicio: this.dt_inicio.value,
      dt_fim: this.dt_fim.value,
      estados: this.multiSelectEstados.value,
      imagemName: this.imageName,
    };

    this.isLoading = true;
    if (idPublicidade) {
      this.publicidadesService
        .editPublicidade(publicidade, idPublicidade)
        .subscribe({
          next: () => {
            this.messageService.add({
              severity: 'success',
              summary: 'Successo',
              detail: 'Publicidade salva com sucesso',
            });
          },
          error: (err) => {
            if (err.error.message) {
              console.log(err);

              this.messageService.add({
                severity: 'error',
                summary: 'Erro',
                detail: err.error.message,
              });
              this.isLoading = false;
            } else {
              this.messageService.add({
                severity: 'error',
                summary: 'Erro',
                detail: 'Erro ao salvar publicidade',
              });
              this.isLoading = false;
              this.closeModal();
            }
          },
          complete: () => {
            this.isLoading = false;
            this.closeModal();
            this.onSavePublicidade.emit();
          },
        });
    } else {
      this.publicidadesService.postPublicidade(publicidade).subscribe({
        next: () => {
          this.messageService.add({
            severity: 'success',
            summary: 'Successo',
            detail: 'Publicidade salva com sucesso',
          });
        },
        error: (err) => {
          if (err.error.message) {
            this.messageService.add({
              severity: 'error',
              summary: 'Erro',
              detail: err.error.message,
            });
            this.isLoading = false;
          } else {
            this.messageService.add({
              severity: 'error',
              summary: 'Erro',
              detail: 'Erro ao salvar publicidade',
            });
            this.isLoading = false;
            this.closeModal();
          }
        },
        complete: () => {
          this.isLoading = false;
          this.closeModal();
          this.onSavePublicidade.emit();
        },
      });
    }
  }

  get isFormInvalid(): boolean {
    return (
      this.publicidadeForm.invalid ||
      this.multiSelectEstados.invalid ||
      this.dt_inicio.invalid ||
      this.dt_fim.invalid ||
      !this.imageUrl
    );
  }

  closeModal() {
    this.visible = false;
  }

  get disableFimDate(): boolean {
    return !this.dt_inicio.value;
  }
}
