import { Estado } from './estado';

export interface Publicidade {
  id: number;
  titulo: string;
  descricao: string;
  imagem: string;
  botao_link: string;
  titulo_botao_link: string;
  dt_inicio: Date;
  dt_fim: Date;
  estados: Estado[];
}

export interface PublicidadeResponse {
  publicidades: Publicidade[];
  publicidade_ativas: Publicidade[];
}

export interface PublicidadeCadastro {
  titulo: string;
  descricao: string;
  imagem: string;
  botao_link: string;
  titulo_botao_link: string;
  dt_inicio: Date;
  dt_fim: Date;
  estados: number[];
}
