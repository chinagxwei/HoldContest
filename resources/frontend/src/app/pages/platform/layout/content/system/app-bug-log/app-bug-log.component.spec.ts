import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AppBugLogComponent } from './app-bug-log.component';

describe('AppBugLogComponent', () => {
  let component: AppBugLogComponent;
  let fixture: ComponentFixture<AppBugLogComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AppBugLogComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(AppBugLogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
