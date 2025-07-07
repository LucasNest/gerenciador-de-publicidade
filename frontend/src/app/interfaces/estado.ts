export interface Estado {
  id: number;
  descricao: string;
  sigla: string;
}

export interface EstadoResponse {
  data: Estado[];
}

export interface EstadoCadastro {
  estado_ids: number[];
}
