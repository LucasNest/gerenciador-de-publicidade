import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { PublicidadeComponent } from './components/publicidade/publicidade.component';

const routes: Routes = [
    {
    path: '',
    redirectTo: 'publicidade',
    pathMatch: 'full'
  },
  {
    path: 'publicidade',
    component: PublicidadeComponent
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
