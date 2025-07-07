import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { EstadoResponse } from 'src/app/interfaces/estado';
import { environment } from 'src/environments/environment.development';

@Injectable({
  providedIn: 'root'
})
export class EstadosService {

  constructor(private http: HttpClient) { }

  getEstados(){
    return this.http.get<any>(`${environment.urlAPi}/estado`)
  }
}
