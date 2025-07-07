import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ButtonModule } from 'primeng/button';
import { PublicidadeComponent } from './publicidade.component';
import { MultiSelectModule } from 'primeng/multiselect';
import { InputTextModule } from 'primeng/inputtext';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { DialogModule } from 'primeng/dialog';
import { InputTextareaModule } from 'primeng/inputtextarea';
import { ModalPublicidadeComponent } from './modal-publicidade/modal-publicidade.component';
import { CardPublicidadeComponent } from './card-publicidade/card-publicidade.component';
import { ImageModule } from 'primeng/image';
import { CalendarModule } from 'primeng/calendar';
import { MenuModule } from 'primeng/menu';
import { CardModule } from 'primeng/card';
import { ChipModule } from 'primeng/chip';
import { AvatarModule } from 'primeng/avatar';
import { FileUploadModule } from 'primeng/fileupload';
import { ToastModule } from 'primeng/toast';
import { MessageService } from 'primeng/api';
import { ProgressSpinnerModule } from 'primeng/progressspinner';
import { ImagePathPipe } from 'src/app/pipes/image-path.pipe';
import { TooltipModule } from 'primeng/tooltip';


@NgModule({
  declarations: [
    PublicidadeComponent,
    ModalPublicidadeComponent,
    CardPublicidadeComponent,
    ImagePathPipe
  ],
  imports: [
    CommonModule,
    ButtonModule,
    FormsModule,
    ReactiveFormsModule,
    DialogModule,
    MultiSelectModule,
    InputTextModule,
    InputTextareaModule,
    CardModule,
    ChipModule,
    MenuModule,
    CalendarModule,
    ImageModule,
    AvatarModule,
    FileUploadModule,
    ToastModule,
    ProgressSpinnerModule,
    TooltipModule

  ],
  exports: [PublicidadeComponent],
  providers: [MessageService],
})
export class PublicidadeModule {}
