import { Component } from '@angular/core';
import { FileUpload } from 'primeng/fileupload';

@Component({
  selector: 'app-modal-publicidade',
  templateUrl: './modal-publicidade.component.html',
  styleUrls: ['./modal-publicidade.component.css'],
})
export class ModalPublicidadeComponent {
  visible: boolean = false;
  teste: any;
  types: any;
  filterTypeValue: any;

  file: File | null = null;
  imageUrl: string | null = null;
  fileName: string | null = null;
  isDragging = false;

  onFileSelected(event: Event): void {
    const input = event.target as HTMLInputElement;
    if (input.files && input.files.length > 0) {
      this.setFile(input.files[0]);
    }
  }

  onDrop(event: DragEvent): void {
    event.preventDefault();
    this.isDragging = false;

    if (event.dataTransfer?.files && event.dataTransfer.files.length > 0) {
      this.setFile(event.dataTransfer.files[0]);
    }
  }

  onDragOver(event: DragEvent): void {
    event.preventDefault();
    this.isDragging = true;
  }

  onDragLeave(event: DragEvent): void {
    event.preventDefault();
    this.isDragging = false;
  }

  removeFile(): void {
    this.file = null;
    this.imageUrl = null;
    this.fileName = null;
  }

  private setFile(file: File): void {
    this.file = file;
    this.fileName = file.name;
    const reader = new FileReader();
    reader.onload = (e: any) => {
      this.imageUrl = e.target.result;
    };
    reader.readAsDataURL(file);
  }

  open() {
    console.log('foi');

    this.visible = true;
  }

  filterType() {}
}
