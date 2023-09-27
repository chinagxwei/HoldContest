import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MemberGameAccountComponent } from './member-game-account.component';

describe('MemberGameAccountComponent', () => {
  let component: MemberGameAccountComponent;
  let fixture: ComponentFixture<MemberGameAccountComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MemberGameAccountComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MemberGameAccountComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
