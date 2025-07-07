export interface Estado {
  id: number;
  descricao: string;
  sigla: string;
}

export interface EstadoResponse {
  estados: Estado[];
}

export interface EstadoCadastro {
  estado_ids: number[];
}
