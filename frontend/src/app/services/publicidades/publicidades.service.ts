import { HttpClient, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { EstadoCadastro } from 'src/app/interfaces/estado';
import { PublicidadeResponse, PublicidadeCadastro } from 'src/app/interfaces/publicidade';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class PublicidadesService {

  constructor(private http: HttpClient) { }

  getPublicidade(search?: string, siglas?: any){
    let params = new HttpParams();

    if (search) {
      params = params.set('search', search);
    }

    if (siglas && siglas.length > 0) {
      siglas.forEach((sigla: any) => {
        params = params.append('estado[]', sigla);
      });
    }
    
    return this.http.get<PublicidadeResponse>(`${environment.urlAPi}/publicidade`, { params })
  }

  postPublicidade(publicidade: PublicidadeCadastro){
    return this.http.post(`${environment.urlAPi}/publicidade`, publicidade)
  }

  editPublicidade(publicidade: PublicidadeCadastro, id: number){
    return this.http.put(`${environment.urlAPi}/publicidade/${id}`, publicidade)
  }

  deletePublicidade(id: number){
    return this.http.delete(`${environment.urlAPi}/publicidade/${id}`)
  }

  vincularEstadosPublicidade(estados: EstadoCadastro, id: number){
    return this.http.put(`${environment.urlAPi}/publicidades/${id}/estados`, estados)
  }
}
