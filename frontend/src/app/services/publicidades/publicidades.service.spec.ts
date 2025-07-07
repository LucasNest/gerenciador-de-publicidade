import { TestBed } from '@angular/core/testing';

import { PublicidadesService } from './publicidades.service';

describe('PublicidadesService', () => {
  let service: PublicidadesService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(PublicidadesService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
