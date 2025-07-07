import { Pipe, PipeTransform } from '@angular/core';
import { environment } from 'src/environments/environment.development';

@Pipe({
  name: 'imagePath',
})
export class ImagePathPipe implements PipeTransform {
  transform(value: string | null | undefined): string {
    if (!value) {
      return 'assets/testeMock.png';
    }

    if (value.startsWith('data:image')) {
      return value;
    }

    return environment.urlImagem + value;
  }
}
