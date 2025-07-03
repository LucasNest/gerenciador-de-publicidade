import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ModalPublicidadeComponent } from './modal-publicidade.component';

describe('ModalPublicidadeComponent', () => {
  let component: ModalPublicidadeComponent;
  let fixture: ComponentFixture<ModalPublicidadeComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ModalPublicidadeComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ModalPublicidadeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
