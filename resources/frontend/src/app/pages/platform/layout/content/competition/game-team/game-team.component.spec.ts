import { ComponentFixture, TestBed } from '@angular/core/testing';

import { GameTeamComponent } from './game-team.component';

describe('GameTeamComponent', () => {
  let component: GameTeamComponent;
  let fixture: ComponentFixture<GameTeamComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ GameTeamComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(GameTeamComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
