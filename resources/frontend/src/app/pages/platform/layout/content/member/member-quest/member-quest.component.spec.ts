import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MemberQuestComponent } from './member-quest.component';

describe('MemberQuestComponent', () => {
  let component: MemberQuestComponent;
  let fixture: ComponentFixture<MemberQuestComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MemberQuestComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MemberQuestComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
