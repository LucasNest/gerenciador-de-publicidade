import { Estado } from './estado';

export interface Publicidade {
  id: number;
  titulo: string;
  descricao: string;
  imagem: string;
  botao_link: string;
  titulo_botao_link: string;
  dt_inicio: string;
  dt_fim: string;
  estados: Estado[];
}

export interface EstadoResponse {
  publicidades: Publicidade[];
  publicidade_ativas: Publicidade[];
}

export interface PublicidadeCadastro {
  id: number;
  titulo: string;
  descricao: string;
  imagem: File;
  botao_link: string;
  titulo_botao_link: string;
  dt_inicio: string;
  dt_fim: string;
  estados: number[];
}
